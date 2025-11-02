<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Professional Student ID Cards</title>
    <style>
        @page {
            size: A4 portrait;
            margin: 2mm;
        }

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'DejaVu Sans', 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background: #f1f5f9;
            color: #1f2937;
            line-height: 1.4;
        }

        .cards-container {
            width: 100%;
            max-width: 210mm;
            margin: 0 auto;
            padding: 0.2mm;
        }

        .cards-table {
            width: 100%;
            border-collapse: separate;
            border-spacing: 4mm;
        }

        .cards-table td {
            vertical-align: top;
            text-align: center;
        }

        .student-card {
            width: 95mm;
            height: 50mm;
            background: #ffffff;
            border-radius: 8px;
            overflow: hidden;
            box-shadow: 0 1px 6px rgba(0, 0, 0, 0.1);
            position: relative;
            page-break-inside: avoid;
            border: 0.3px solid #e2e8f0;
            display: inline-block;
        }

        .card-front {
            display: table;
            width: 100%;
            height: 80%;
            table-layout: fixed;
        }

        .card-sidebar {
            display: table-cell;
            width: 35%;
            background: linear-gradient(160deg, #15803d 0%, #16a34a 30%, #22c55e 70%, #4ade80 100%);
            vertical-align: middle;
            text-align: center;
            padding: 1.5mm 0.5mm;
            position: relative;
            overflow: hidden;
        }

        .card-sidebar::before {
            content: "";
            position: absolute;
            top: -50%;
            left: -50%;
            width: 200%;
            height: 200%;
            background: radial-gradient(circle at 30% 30%, rgba(255, 255, 255, 0.2) 0%, transparent 50%);
            pointer-events: none;
        }

        .card-sidebar::after {
            content: "";
            position: absolute;
            bottom: 0;
            right: 0;
            width: 60%;
            height: 60%;
            background: radial-gradient(circle at 80% 80%, rgba(0, 0, 0, 0.1) 0%, transparent 60%);
            pointer-events: none;
        }

        .qr-code-container {
            width: 22mm;
            height: 22mm;
            background: #ffffff;
            border-radius: 6px;
            padding: 1mm;
            display: inline-block;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.2);
            z-index: 3;
            position: relative;
        }

        .qr-code-container img {
            width: 100%;
            height: 100%;
            object-fit: contain;
            display: block;
        }

        .qr-placeholder {
            width: 18mm;
            height: 18mm;
            background: #ffffff;
            border-radius: 4px;
            padding: 0.5mm;
            display: inline-block;
            box-shadow: 0 1px 4px rgba(0, 0, 0, 0.15);
            z-index: 3;
            position: relative;
        }

        .qr-placeholder-content {
            display: table-cell;
            vertical-align: middle;
        }

        .card-content {
            display: table-cell;
            width: 95%;
            vertical-align: top;
            padding: 0.5mm 0.8mm;
            background: #ffffff;
        }

        .institution-header {
            text-align: center;
            padding-bottom: 0.5mm;
            border-bottom: 1px solid #16a34a;
            margin-bottom: 0.8mm;
        }

        .institution-name {
            font-size: 6pt;
            font-weight: 800;
            color: #16a34a;
            letter-spacing: 0.8px;
            text-transform: uppercase;
            line-height: 1.1;
        }

        .academic-session {
            font-size: 5pt;
            color: #64748b;
            font-weight: 600;
            margin-top: 0.5mm;
            text-transform: uppercase;
        }

        .student-details {
            margin: 0.5mm 0;
        }

        .details-table {
            width: 100%;
            border-collapse: collapse;
        }

        .details-table td {
            padding: 0.5mm 0;
            vertical-align: top;
            text-align: left;
        }

        .detail-label {
            font-size: 4.5pt;
            color: #64748b;
            text-transform: uppercase;
            font-weight: 700;
            letter-spacing: 0.2px;
            padding-bottom: 0.2mm;
        }

        .detail-value {
            font-size: 6pt;
            font-weight: 700;
            color: #1f2937;
            line-height: 1.1;
        }

        .student-name {
            font-size: 7pt;
            font-weight: 800;
            color: #0f172a;
        }

        .matric-number {
            font-size: 6.5pt;
            font-weight: 800;
            color: #f59e0b;
        }

        .card-footer {
            text-align: center;
            border-top: 1px dashed #cbd5e1;
            padding-top: 0.5mm;
            margin-top: 0.5mm;
        }

        .validity-text {
            font-size: 4pt;
            color: #94a3b8;
            font-style: italic;
        }

        .card-back {
            height: 100%;
            background: linear-gradient(to bottom, #ffffff 0%, #f9fafb 100%);
            position: relative;
            overflow: hidden;
        }

        .back-header {
            height: 6mm;
            background: linear-gradient(100deg, #15803d 0%, #16a34a 25%, #22c55e 50%, #facc15 75%, #f59e0b 100%);
            position: relative;
        }

        .back-header::before {
            content: "";
            position: absolute;
            inset: 0;
            background: linear-gradient(100deg,
                    rgba(255, 255, 255, 0.15) 0%,
                    transparent 30%,
                    rgba(255, 255, 255, 0.1) 50%,
                    transparent 70%,
                    rgba(0, 0, 0, 0.08) 100%);
        }

        .back-content {
            padding: 0.5mm 0.8mm;
            height: calc(100% - 6mm);
        }

        .back-content-table {
            width: 100%;
            height: 100%;
            border-collapse: collapse;
        }

        .back-content-table td {
            vertical-align: top;
            padding: 0;
        }

        .info-section {
            margin-bottom: 0.8mm;
        }

        .section-title {
            font-size: 5.5pt;
            font-weight: 800;
            color: #16a34a;
            text-transform: uppercase;
            margin-bottom: 0.8mm;
            letter-spacing: 0.2px;
        }

        .section-text {
            font-size: 4.5pt;
            color: #475569;
            line-height: 1.3;
        }

        .emergency-section {
            background: linear-gradient(135deg, #fef3c7 0%, #fde68a 100%);
            border-left: 2px solid #f59e0b;
            border-radius: 3px;
            padding: 0.8mm 1mm;
            margin: 0.8mm 0;
            box-shadow: 0 1px 2px rgba(245, 158, 11, 0.1);
        }

        .emergency-section .section-title {
            color: #d97706;
            font-size: 5pt;
        }

        .emergency-section .section-text {
            color: #92400e;
        }

        .signatures-section {
            margin-top: 1mm;
        }

        .signatures-table {
            width: 100%;
            border-collapse: collapse;
        }

        .signatures-table td {
            width: 50%;
            text-align: center;
            vertical-align: bottom;
        }

        .signature-line {
            border-top: 1px solid #64748b;
            margin-bottom: 0.8mm;
        }

        .signature-label {
            font-size: 4pt;
            color: #64748b;
            text-transform: uppercase;
            font-weight: 600;
            letter-spacing: 0.2px;
        }

        .page-break {
            page-break-after: always;
        }

        @media print {
            body {
                background: #ffffff;
                -webkit-print-color-adjust: exact;
                print-color-adjust: exact;
            }

            .student-card {
                box-shadow: 0 1px 2px rgba(0, 0, 0, 0.06);
            }

            .cards-container {
                padding: 0;
            }

            .cards-table {
                border-spacing: 3mm;
            }
        }
    </style>
</head>

<body>
    <div class="cards-container">
        <table class="cards-table">
            @foreach ($students as $index => $student)
                <!-- FRONT SIDE -->
                <tr>
                    <td>
                        <div class="student-card">
                            <div class="card-front">
                                <div class="card-sidebar">
                                    <div class="qr-code-container">
                                        @if ($student->getQrCode())
                                            <img src="data:image/svg+xml;base64,{{ base64_encode($student->getQrCode()) }}"
                                                alt="QR Code">
                                        @else
                                            <div class="qr-placeholder">
                                                <div class="qr-placeholder-content">
                                                    <strong>QR</strong><br>
                                                    <span>N/A</span>
                                                </div>
                                            </div>
                                        @endif
                                    </div>
                                </div>

                                <div class="card-content">
                                    <div class="institution-header">
                                        <div class="institution-name">
                                            BAMIDELE OLUMILUA UNIVERSITY OF EDUCATION, SCIENCE AND TECHNOLOGY
                                        </div>
                                        <div class="academic-session">
                                            Academic Session {{ date('Y') - 1 }}/{{ date('Y') }}
                                        </div>
                                    </div>

                                    <div class="student-details">
                                        <table class="details-table">
                                            <tr>
                                                <td>
                                                    <div class="detail-label">Student Name</div>
                                                    <div class="detail-value student-name">{{ strtoupper($student->name) }}</div>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>
                                                    <div class="detail-label">Matric Number</div>
                                                    <div class="detail-value matric-number">
                                                        {{ $student->student_id ?? ($student->matric_no ?? 'N/A') }}
                                                    </div>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>
                                                    <div class="detail-label">Department</div>
                                                    <div class="detail-value">
                                                        {{ $student->department->name ?? 'Not Assigned' }}
                                                    </div>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>
                                                    <div class="detail-label">Level</div>
                                                    <div class="detail-value">{{ $student->level ?? '100' }} Level</div>
                                                </td>
                                            </tr>
                                        </table>
                                    </div>

                                    <div class="card-footer">
                                        <div class="validity-text">Valid for current academic session only</div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </td>
                </tr>

                <!-- BACK SIDE -->
                <tr>
                    <td>
                        <div class="student-card">
                            <div class="card-back">
                                <div class="back-header"></div>

                                <div class="back-content">
                                    <table class="back-content-table">
                                        <tr>
                                            <td>
                                                <div class="info-section">
                                                    <div class="section-title">Institution Information</div>
                                                    <div class="section-text">
                                                        Bamidele Olumilua University of Education, Science and Technology,
                                                        Ikere-Ekiti, Ekiti State, Nigeria.<br>
                                                        Website: www.bouesti.edu.ng | Email: info@bouesti.edu.ng
                                                    </div>
                                                </div>

                                                <div class="info-section">
                                                    <div class="section-title">Contact Information</div>
                                                    <div class="section-text">
                                                        Registry: +234 806 123 4567<br>
                                                        Student Affairs: +234 807 234 5678
                                                    </div>
                                                </div>

                                                <div class="emergency-section">
                                                    <div class="section-title">Emergency Contact</div>
                                                    <div class="section-text">
                                                        In case of emergency, contact Student Affairs Division immediately.<br>
                                                        Emergency Line: +234 812 345 6789
                                                    </div>
                                                </div>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td style="vertical-align: bottom;">
                                                <div class="signatures-section">
                                                    <table class="signatures-table">
                                                        <tr>
                                                            <td>
                                                                <div class="signature-line"></div>
                                                                <div class="signature-label">Holder's Signature</div>
                                                            </td>
                                                            <td>
                                                                <div class="signature-line"></div>
                                                                <div class="signature-label">Registrar</div>
                                                            </td>
                                                        </tr>
                                                    </table>
                                                </div>
                                            </td>
                                        </tr>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </td>
                </tr>

                <!-- PAGE BREAK -->
                <tr>
                    <td class="page-break"></td>
                </tr>
            @endforeach
        </table>
    </div>
</body>

</html>
