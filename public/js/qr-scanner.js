/**
 * QR Code Scanner for Student Attendance
 * Uses HTML5 getUserMedia API and jsQR library for QR code detection
 */

class QRScanner {
    constructor(videoElement, canvasElement, resultCallback) {
        this.video = videoElement;
        this.canvas = canvasElement;
        this.context = this.canvas.getContext('2d');
        this.resultCallback = resultCallback;
        this.stream = null;
        this.scanning = false;
        this.animationId = null;
    }

    async startScanning() {
        try {
            // Check if getUserMedia is supported
            if (!navigator.mediaDevices || !navigator.mediaDevices.getUserMedia) {
                throw new Error('Camera access is not supported by this browser');
            }

            // Request camera access with fallback options
            const constraints = {
                video: {
                    facingMode: 'environment', // Use back camera if available
                    width: { ideal: 1280, min: 640 },
                    height: { ideal: 720, min: 480 }
                }
            };

            try {
                this.stream = await navigator.mediaDevices.getUserMedia(constraints);
            } catch (error) {
                // Fallback to basic constraints if the ideal ones fail
                console.warn('Falling back to basic camera constraints:', error);
                this.stream = await navigator.mediaDevices.getUserMedia({
                    video: true
                });
            }

            this.video.srcObject = this.stream;
            this.video.setAttribute('playsinline', true);
            
            // Wait for video to be ready
            await new Promise((resolve, reject) => {
                this.video.onloadedmetadata = () => {
                    this.video.play()
                        .then(() => {
                            this.canvas.width = this.video.videoWidth;
                            this.canvas.height = this.video.videoHeight;
                            this.scanning = true;
                            this.scanFrame();
                            resolve();
                        })
                        .catch(reject);
                };
                
                this.video.onerror = () => {
                    reject(new Error('Failed to load video stream'));
                };
                
                // Timeout after 10 seconds
                setTimeout(() => {
                    reject(new Error('Camera initialization timed out'));
                }, 10000);
            });

            return true;
        } catch (error) {
            console.error('Error accessing camera:', error);
            
            // Provide specific error messages based on error type
            let errorMessage = 'Camera access failed';
            
            if (error.name === 'NotAllowedError' || error.name === 'PermissionDeniedError') {
                errorMessage = 'Camera permission denied. Please allow camera access and try again.';
            } else if (error.name === 'NotFoundError' || error.name === 'DevicesNotFoundError') {
                errorMessage = 'No camera found. Please connect a camera and try again.';
            } else if (error.name === 'NotReadableError' || error.name === 'TrackStartError') {
                errorMessage = 'Camera is already in use by another application.';
            } else if (error.name === 'OverconstrainedError' || error.name === 'ConstraintNotSatisfiedError') {
                errorMessage = 'Camera does not meet the required specifications.';
            } else if (error.message) {
                errorMessage = error.message;
            }
            
            throw new Error(errorMessage);
        }
    }

    scanFrame() {
        if (!this.scanning) return;

        if (this.video.readyState === this.video.HAVE_ENOUGH_DATA) {
            // Draw video frame to canvas
            this.context.drawImage(this.video, 0, 0, this.canvas.width, this.canvas.height);
            
            // Get image data for QR scanning
            const imageData = this.context.getImageData(0, 0, this.canvas.width, this.canvas.height);
            
            // Scan for QR code using jsQR
            if (window.jsQR) {
                const code = jsQR(imageData.data, imageData.width, imageData.height, {
                    inversionAttempts: "dontInvert",
                });

                if (code) {
                    this.handleQRCodeDetected(code.data);
                    return;
                }
            }
        }

        // Continue scanning
        this.animationId = requestAnimationFrame(() => this.scanFrame());
    }

    handleQRCodeDetected(qrData) {
        if (this.scanning) {
            this.scanning = false;
            
            // Parse QR code data
            const studentData = this.parseQRData(qrData);
            
            if (studentData) {
                this.resultCallback(studentData);
            } else {
                this.resultCallback({ error: 'Invalid QR code format' });
            }
        }
    }

    parseQRData(qrData) {
        try {
            // The QR code contains student data in this format:
            // Name: John Doe
            // Email: john@example.com
            // Matric No: CS/2020/001
            // Department: Computer Science
            // Level: 400
            
            const lines = qrData.split('\n');
            const studentData = {};
            
            lines.forEach(line => {
                const [key, ...valueParts] = line.split(':');
                if (key && valueParts.length > 0) {
                    const value = valueParts.join(':').trim();
                    const cleanKey = key.trim().toLowerCase().replace(/\s+/g, '_');
                    
                    switch (cleanKey) {
                        case 'name':
                            studentData.name = value;
                            break;
                        case 'email':
                            studentData.email = value;
                            break;
                        case 'matric_no':
                        case 'matric no':
                            studentData.matric_no = value;
                            break;
                        case 'department':
                            studentData.department = value;
                            break;
                        case 'level':
                            studentData.level = parseInt(value);
                            break;
                    }
                }
            });
            
            // Validate required fields
            if (studentData.name && studentData.matric_no && studentData.department) {
                return studentData;
            }
            
            return null;
        } catch (error) {
            console.error('Error parsing QR data:', error);
            return null;
        }
    }

    stopScanning() {
        this.scanning = false;
        
        if (this.animationId) {
            cancelAnimationFrame(this.animationId);
            this.animationId = null;
        }
        
        if (this.stream) {
            this.stream.getTracks().forEach(track => track.stop());
            this.stream = null;
        }
        
        if (this.video.srcObject) {
            this.video.srcObject = null;
        }
    }

    restartScanning() {
        this.stopScanning();
        setTimeout(() => {
            this.startScanning();
        }, 100);
    }
}

// Global QR Scanner instance
window.QRScanner = QRScanner;