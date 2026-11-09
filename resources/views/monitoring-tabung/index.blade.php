@extends('layouts.master')

@section('title', 'Monitoring Perputaran Tabung')

@section('content')
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.13.1/font/bootstrap-icons.min.css">

    {{-- =============================================================
    STYLE
============================================================= --}}
    <style>
        :root {
            --primary: #024E7F;
            --primary-dark: #013B61;
            --primary-light: #EAF5FB;

            --danger: #DC3545;
            --danger-light: #FFF0F2;

            --warning: #F59E0B;
            --warning-light: #FFF8E7;

            --success: #16A34A;
            --success-light: #ECFDF3;

            --text-dark: #172B4D;
            --text-muted: #718096;

            --border: #E8EDF2;

            --radius: 16px;
        }


        /* =========================================================
                                                                                                                                                                       PAGE
                                                                                                                                                                    ========================================================= */

        .monitoring-page {
            padding: 24px 20px 50px;
            max-width: 1600px;
            margin: auto;
            color: var(--text-dark);
        }


        /* =========================================================
                                                                                                                                                                       HEADER
                                                                                                                                                                    ========================================================= */

        .monitoring-header {
            position: relative;
            overflow: hidden;

            display: flex;
            justify-content: space-between;
            align-items: center;

            padding: 28px 30px;

            margin-bottom: 22px;

            border-radius: 20px;

            background:
                linear-gradient(135deg,
                    #024E7F 0%,
                    #05699F 55%,
                    #0284C7 100%);

            color: white;

            box-shadow:
                0 12px 35px rgba(2, 78, 127, .18);
        }


        .monitoring-header::before {
            content: "";

            position: absolute;

            width: 250px;
            height: 250px;

            right: -80px;
            top: -130px;

            border-radius: 50%;

            background: rgba(255, 255, 255, .08);
        }


        .monitoring-header::after {
            content: "";

            position: absolute;

            width: 160px;
            height: 160px;

            right: 150px;
            bottom: -110px;

            border-radius: 50%;

            background: rgba(255, 255, 255, .05);
        }


        .header-content {
            position: relative;
            z-index: 2;

            display: flex;
            align-items: center;

            gap: 18px;
        }


        .header-icon {
            width: 64px;
            height: 64px;

            flex-shrink: 0;

            display: flex;
            align-items: center;
            justify-content: center;

            border-radius: 18px;

            background: rgba(255, 255, 255, .15);

            border: 1px solid rgba(255, 255, 255, .2);

            font-size: 28px;

            backdrop-filter: blur(5px);
        }


        .header-label {
            display: block;

            margin-bottom: 4px;

            font-size: 11px;
            font-weight: 700;

            letter-spacing: 1.5px;

            opacity: .75;
        }


        .header-text h1 {
            margin: 0;

            font-size: 26px;
            font-weight: 800;

            letter-spacing: -.4px;
        }


        .header-text p {
            margin: 5px 0 0;

            max-width: 680px;

            font-size: 13px;

            color: rgba(255, 255, 255, .78);
        }


        .header-date {
            position: relative;
            z-index: 2;

            min-width: 180px;

            text-align: right;
        }


        .header-date span {
            display: block;

            font-size: 11px;

            color: rgba(255, 255, 255, .7);
        }


        .header-date strong {
            display: block;

            margin: 3px 0;

            font-size: 14px;
        }


        .header-date small {
            display: flex;

            justify-content: flex-end;
            align-items: center;

            gap: 6px;

            font-size: 11px;

            color: rgba(255, 255, 255, .8);
        }


        .live-dot {
            width: 7px !important;
            height: 7px;

            display: inline-block !important;

            border-radius: 50%;

            background: #4ADE80;

            box-shadow: 0 0 0 4px rgba(74, 222, 128, .15);
        }


        /* =========================================================
                                                                                                                                                                       MAIN ALERT
                                                                                                                                                                    ========================================================= */

        .main-alert {
            display: flex;
            justify-content: space-between;
            align-items: center;

            gap: 20px;

            padding: 20px 24px;

            margin-bottom: 22px;

            border: 1px solid #FECACA;

            border-radius: var(--radius);

            background: linear-gradient(135deg,
                    #FFF5F5,
                    #FFF);

            box-shadow: 0 5px 20px rgba(220, 53, 69, .06);
        }


        .alert-left {
            display: flex;
            align-items: center;
            gap: 16px;
        }


        .main-alert .alert-icon {
            width: 52px;
            height: 52px;

            flex-shrink: 0;

            display: flex;
            align-items: center;
            justify-content: center;

            border-radius: 14px;

            background: #FEE2E2;

            color: var(--danger);

            font-size: 22px;
        }


        .alert-small-title {
            font-size: 10px;
            font-weight: 800;

            letter-spacing: 1.3px;

            color: var(--danger);
        }


        .main-alert h4 {
            margin: 2px 0 3px;

            font-size: 16px;
            font-weight: 800;

            color: #7F1D1D;
        }


        .main-alert p {
            margin: 0;

            font-size: 13px;

            color: #991B1B;
        }


        .alert-count {
            min-width: 110px;

            text-align: center;
        }


        .alert-count strong {
            display: block;

            font-size: 32px;
            line-height: 1;

            color: var(--danger);
        }


        .alert-count span {
            font-size: 11px;
            font-weight: 600;

            color: #991B1B;
        }


        /* =========================================================
                                                                                                                                                                       SUCCESS ALERT
                                                                                                                                                                    ========================================================= */

        .success-alert {
            border-color: #BBF7D0;

            background:
                linear-gradient(135deg,
                    #F0FDF4,
                    #FFFFFF);
        }


        .success-alert .alert-icon {
            background: #DCFCE7;

            color: var(--success);
        }


        .success-alert .alert-small-title {
            color: var(--success);
        }


        .success-alert h4 {
            color: #166534;
        }


        .success-alert p {
            color: #15803D;
        }


        .success-alert .alert-count strong {
            color: var(--success);
        }


        .success-alert .alert-count span {
            color: #15803D;
        }


        .success-alert .alert-count i {
            display: block;

            font-size: 30px;

            color: var(--success);
        }


        /* =========================================================
                                                                                                                                                                       STATISTICS
                                                                                                                                                                    ========================================================= */

        .stats-grid {
            display: grid;

            grid-template-columns:
                repeat(4, minmax(0, 1fr));

            gap: 16px;

            margin-bottom: 24px;
        }


        .stat-card {
            position: relative;

            overflow: hidden;

            min-height: 170px;

            padding: 20px;

            border-radius: var(--radius);

            background: white;

            border: 1px solid var(--border);

            box-shadow:
                0 5px 20px rgba(15, 23, 42, .04);

            transition:
                transform .25s ease,
                box-shadow .25s ease;
        }


        .stat-card:hover {
            transform: translateY(-4px);

            box-shadow:
                0 12px 28px rgba(15, 23, 42, .09);
        }


        .stat-card::after {
            content: "";

            position: absolute;

            width: 100px;
            height: 100px;

            right: -35px;
            bottom: -45px;

            border-radius: 50%;

            opacity: .05;
        }


        .stat-blue::after {
            background: #0EA5E9;
        }


        .stat-red::after {
            background: #EF4444;
        }


        .stat-orange::after {
            background: #F59E0B;
        }


        .stat-green::after {
            background: #22C55E;
        }


        .stat-top {
            display: flex;
            justify-content: space-between;
            align-items: flex-start;
        }


        .stat-label {
            display: block;

            margin-bottom: 8px;

            font-size: 10px;
            font-weight: 800;

            letter-spacing: 1px;

            color: var(--text-muted);
        }


        .stat-number {
            font-size: 32px;
            line-height: 1;

            font-weight: 800;

            letter-spacing: -1px;

            color: var(--text-dark);
        }


        .stat-description {
            display: block;

            margin-top: 6px;

            font-size: 11px;

            color: var(--text-muted);
        }


        .stat-icon {
            width: 48px;
            height: 48px;

            display: flex;
            align-items: center;
            justify-content: center;

            border-radius: 14px;

            font-size: 20px;
        }


        .stat-blue .stat-icon {
            background: #E0F2FE;
            color: #0284C7;
        }


        .stat-red .stat-icon {
            background: #FEE2E2;
            color: #DC2626;
        }


        .stat-orange .stat-icon {
            background: #FEF3C7;
            color: #D97706;
        }


        .stat-green .stat-icon {
            background: #DCFCE7;
            color: #16A34A;
        }


        .stat-footer {
            position: absolute;

            left: 20px;
            right: 20px;
            bottom: 16px;

            padding-top: 11px;

            border-top: 1px solid #F1F5F9;

            font-size: 10px;

            color: var(--text-muted);
        }


        .stat-footer i {
            margin-right: 4px;
        }


        .stat-red .stat-footer i {
            color: var(--danger);
        }


        .stat-orange .stat-footer i {
            color: var(--warning);
        }


        .stat-green .stat-footer i {
            color: var(--success);
        }


        .stat-blue .stat-footer i {
            color: #0284C7;
        }


        /* =========================================================
                                                                                                                                                                       FILTER
                                                                                                                                                                    ========================================================= */

        .filter-card {
            padding: 20px 22px;

            margin-bottom: 30px;

            border-radius: var(--radius);

            background: white;

            border: 1px solid var(--border);

            box-shadow:
                0 5px 20px rgba(15, 23, 42, .04);
        }


        .filter-title {
            display: flex;
            align-items: center;

            gap: 12px;

            margin-bottom: 17px;
        }


        .filter-title-icon {
            width: 40px;
            height: 40px;

            display: flex;
            align-items: center;
            justify-content: center;

            border-radius: 11px;

            background: var(--primary-light);

            color: var(--primary);
        }


        .filter-title h5 {
            margin: 0;

            font-size: 14px;
            font-weight: 800;
        }


        .filter-title span {
            display: block;

            margin-top: 2px;

            font-size: 11px;

            color: var(--text-muted);
        }


        .filter-row {
            display: flex;

            align-items: flex-end;

            gap: 10px;
        }


        .filter-field {
            flex: 1;
        }


        .filter-field label {
            display: block;

            margin-bottom: 7px;

            font-size: 11px;
            font-weight: 700;

            color: var(--text-dark);
        }


        .input-icon {
            position: relative;
        }


        .input-icon>i {
            position: absolute;

            left: 14px;
            top: 50%;

            transform: translateY(-50%);

            color: var(--primary);

            z-index: 2;
        }


        .input-icon select {
            width: 100%;

            min-height: 44px;

            padding: 0 40px 0 40px;

            border: 1px solid var(--border);

            border-radius: 10px;

            background: #F8FAFC;

            color: var(--text-dark);

            font-size: 13px;

            outline: none;

            cursor: pointer;

            transition: .2s;
        }


        .input-icon select:focus {
            border-color: var(--primary);

            background: white;

            box-shadow:
                0 0 0 3px rgba(2, 78, 127, .08);
        }


        .filter-btn,
        .reset-btn {
            min-height: 44px;

            padding: 0 20px;

            display: inline-flex;
            align-items: center;
            justify-content: center;

            gap: 7px;

            border-radius: 10px;

            font-size: 12px;
            font-weight: 700;

            text-decoration: none;

            transition: .2s;
        }


        .filter-btn {
            border: 0;

            background: var(--primary);

            color: white;
        }


        .filter-btn:hover {
            background: var(--primary-dark);

            color: white;

            transform: translateY(-1px);
        }


        .reset-btn {
            border: 1px solid var(--border);

            background: white;

            color: #64748B;
        }


        .reset-btn:hover {
            background: #F8FAFC;

            color: var(--text-dark);
        }


        /* =========================================================
                                                                                                                                                                       SECTION HEADER
                                                                                                                                                                    ========================================================= */

        .section-header {
            display: flex;
            justify-content: space-between;
            align-items: flex-end;

            margin-bottom: 14px;
        }


        .section-label {
            display: block;

            margin-bottom: 4px;

            font-size: 9px;
            font-weight: 800;

            letter-spacing: 1.5px;

            color: var(--primary);
        }


        .section-header h4 {
            margin: 0;

            font-size: 18px;
            font-weight: 800;

            color: var(--text-dark);
        }


        .section-count {
            padding: 6px 12px;

            border-radius: 30px;

            background: var(--primary-light);

            color: var(--primary);

            font-size: 11px;
            font-weight: 700;
        }


        /* =========================================================
                                                                                                                                                                       OUTLET GRID
                                                                                                                                                                    ========================================================= */

        .outlet-grid {
            display: grid;

            grid-template-columns:
                repeat(3, minmax(0, 1fr));

            gap: 15px;

            margin-bottom: 32px;
        }


        .outlet-card {
            position: relative;

            overflow: hidden;

            padding: 18px;

            border-radius: var(--radius);

            background: white;

            border: 1px solid var(--border);

            box-shadow:
                0 5px 18px rgba(15, 23, 42, .04);

            transition: .25s;
        }


        .outlet-card:hover {
            transform: translateY(-3px);

            box-shadow:
                0 10px 25px rgba(15, 23, 42, .08);
        }


        .outlet-card.has-alert {
            border-color: #FECACA;
        }


        .outlet-card.is-safe {
            border-color: #BBF7D0;
        }


        .outlet-card-top {
            display: flex;
            justify-content: space-between;
            align-items: center;

            margin-bottom: 13px;
        }


        .outlet-icon {
            width: 38px;
            height: 38px;

            display: flex;
            align-items: center;
            justify-content: center;

            border-radius: 10px;

            background: var(--primary-light);

            color: var(--primary);
        }


        .outlet-status {
            display: inline-flex;
            align-items: center;

            gap: 5px;

            padding: 5px 9px;

            border-radius: 30px;

            font-size: 10px;
            font-weight: 700;
        }


        .status-danger {
            background: #FEE2E2;

            color: #B91C1C;
        }


        .status-safe {
            background: #DCFCE7;

            color: #15803D;
        }


        .outlet-name {
            margin-bottom: 4px;

            font-size: 14px;
            font-weight: 800;

            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
        }


        .outlet-total {
            margin-bottom: 13px;

            font-size: 23px;
            font-weight: 800;
        }


        .outlet-total span {
            font-size: 11px;
            font-weight: 500;

            color: var(--text-muted);
        }


        .outlet-progress {
            display: flex;

            overflow: hidden;

            width: 100%;
            height: 7px;

            margin-bottom: 12px;

            border-radius: 10px;

            background: #F1F5F9;
        }


        .progress-alert {
            background: #EF4444;
        }


        .progress-warning {
            background: #F59E0B;
        }


        .progress-normal {
            background: #22C55E;
        }


        .outlet-info {
            display: grid;

            grid-template-columns:
                repeat(3, 1fr);

            gap: 5px;
        }


        .outlet-info>div {
            display: flex;
            align-items: center;

            gap: 4px;

            font-size: 9px;

            color: var(--text-muted);
        }


        .outlet-info strong {
            margin-left: auto;

            font-size: 10px;

            color: var(--text-dark);
        }


        .dot {
            width: 6px;
            height: 6px;

            flex-shrink: 0;

            border-radius: 50%;
        }


        .dot-danger {
            background: #EF4444;
        }


        .dot-warning {
            background: #F59E0B;
        }


        .dot-success {
            background: #22C55E;
        }


        /* =========================================================
                                                                                                                                                                       TABLE HEADER
                                                                                                                                                                    ========================================================= */

        .table-section-header {
            align-items: center;

            margin-top: 5px;
        }


        .table-section-header p {
            margin: 4px 0 0;

            font-size: 11px;

            color: var(--text-muted);
        }


        .table-total {
            display: flex;
            align-items: baseline;

            gap: 5px;

            padding: 8px 14px;

            border-radius: 10px;

            background: #F8FAFC;
        }


        .table-total strong {
            font-size: 18px;

            color: var(--primary);
        }


        .table-total span {
            font-size: 10px;

            color: var(--text-muted);
        }


        /* =========================================================
                                                                                                                                                                       DESKTOP TABLE
                                                                                                                                                                    ========================================================= */

        .table-card {
            overflow: hidden;

            margin-bottom: 20px;

            border: 1px solid var(--border);

            border-radius: var(--radius);

            background: white;

            box-shadow:
                0 5px 20px rgba(15, 23, 42, .04);
        }


        .monitoring-table {
            width: 100%;

            margin: 0;

            border-collapse: collapse;
        }


        .monitoring-table thead {
            background: #F8FAFC;
        }


        .monitoring-table th {
            padding: 14px 18px;

            border-bottom: 1px solid var(--border);

            color: #64748B;

            font-size: 10px;
            font-weight: 800;

            text-transform: uppercase;

            letter-spacing: .5px;

            white-space: nowrap;
        }


        .monitoring-table td {
            padding: 15px 18px;

            border-bottom: 1px solid #F1F5F9;

            font-size: 12px;

            vertical-align: middle;
        }


        .monitoring-table tbody tr {
            transition: .2s;
        }


        .monitoring-table tbody tr:hover {
            background: #F8FBFD;
        }


        .monitoring-table tbody tr:last-child td {
            border-bottom: 0;
        }


        .number-column {
            width: 45px;

            color: #94A3B8;

            font-weight: 700;
        }


        .tube-code {
            display: flex;
            align-items: center;

            gap: 10px;
        }


        .tube-icon {
            width: 36px;
            height: 36px;

            display: flex;
            align-items: center;
            justify-content: center;

            flex-shrink: 0;

            border-radius: 9px;

            background: #EFF6FF;

            color: #2563EB;
        }


        .tube-code strong {
            display: block;

            font-size: 12px;

            color: var(--primary);
        }


        .tube-code small {
            display: block;

            margin-top: 2px;

            font-size: 9px;

            color: #94A3B8;
        }


        .outlet-table {
            display: flex;
            align-items: center;

            gap: 7px;

            font-weight: 600;
        }


        .outlet-table i {
            color: var(--primary);
        }


        .date-table strong {
            display: block;

            font-size: 11px;
        }


        .date-table small {
            display: block;

            margin-top: 2px;

            font-size: 9px;

            color: #94A3B8;
        }


        .duration {
            display: flex;
            align-items: baseline;

            gap: 4px;
        }


        .duration strong {
            font-size: 20px;

            color: var(--text-dark);
        }


        .duration span {
            font-size: 10px;

            color: var(--text-muted);
        }


        .status-badge {
            display: inline-flex;
            align-items: center;

            gap: 5px;

            padding: 7px 10px;

            border-radius: 30px;

            font-size: 9px;
            font-weight: 800;

            white-space: nowrap;
        }


        .badge-danger {
            background: #FEE2E2;

            color: #B91C1C;
        }


        .badge-warning {
            background: #FEF3C7;

            color: #B45309;
        }


        .badge-success {
            background: #DCFCE7;

            color: #15803D;
        }


        /* =========================================================
                                                                                                                                                                       MOBILE TUBE
                                                                                                                                                                    ========================================================= */

        .mobile-tube-list {
            display: none;
        }


        .mobile-tube-card {
            position: relative;

            overflow: hidden;

            margin-bottom: 12px;

            border: 1px solid var(--border);

            border-radius: 15px;

            background: white;

            box-shadow:
                0 4px 15px rgba(15, 23, 42, .04);
        }


        .mobile-tube-card::before {
            content: "";

            position: absolute;

            left: 0;
            top: 0;
            bottom: 0;

            width: 4px;
        }


        .tube-alert::before {
            background: #EF4444;
        }


        .tube-warning::before {
            background: #F59E0B;
        }


        .tube-normal::before {
            background: #22C55E;
        }


        .mobile-tube-header {
            display: flex;
            justify-content: space-between;
            align-items: center;

            gap: 10px;

            padding: 15px;

            border-bottom: 1px solid #F1F5F9;
        }


        .mobile-tube-code {
            display: flex;
            align-items: center;

            gap: 10px;

            min-width: 0;
        }


        .mobile-tube-code>div:last-child {
            min-width: 0;
        }


        .mobile-tube-code span {
            display: block;

            margin-bottom: 2px;

            font-size: 8px;
            font-weight: 700;

            color: #94A3B8;

            letter-spacing: .7px;
        }


        .mobile-tube-code strong {
            display: block;

            overflow: hidden;

            text-overflow: ellipsis;
            white-space: nowrap;

            font-size: 13px;

            color: var(--primary);
        }


        .mobile-tube-body {
            padding: 14px 15px;
        }


        .mobile-info {
            display: flex;
            justify-content: space-between;
            align-items: center;

            gap: 10px;

            padding: 7px 0;

            border-bottom: 1px dashed #E2E8F0;
        }


        .mobile-info:last-of-type {
            border-bottom: 0;
        }


        .mobile-info span {
            display: flex;
            align-items: center;

            gap: 6px;

            font-size: 10px;

            color: var(--text-muted);
        }


        .mobile-info span i {
            color: var(--primary);
        }


        .mobile-info strong {
            max-width: 55%;

            overflow: hidden;

            text-align: right;

            text-overflow: ellipsis;

            white-space: nowrap;

            font-size: 10px;
        }


        .mobile-duration {
            display: flex;
            justify-content: space-between;
            align-items: center;

            margin-top: 10px;
            padding: 12px;

            border-radius: 11px;

            background: #F8FAFC;
        }


        .mobile-duration span {
            display: block;

            margin-bottom: 3px;

            font-size: 9px;

            color: var(--text-muted);
        }


        .mobile-duration strong {
            display: block;

            font-size: 21px;
            line-height: 1;

            color: var(--text-dark);
        }


        .mobile-duration strong small {
            font-size: 10px;

            font-weight: 500;

            color: var(--text-muted);
        }


        .mobile-duration>i {
            font-size: 22px;
        }


        .tube-alert .mobile-duration>i {
            color: var(--danger);
        }


        .tube-warning .mobile-duration>i {
            color: var(--warning);
        }


        .tube-normal .mobile-duration>i {
            color: var(--success);
        }


        /* =========================================================
                                                                                                                                                                       EMPTY STATE
                                                                                                                                                                    ========================================================= */

        .empty-state {
            padding: 60px 25px;

            text-align: center;

            border: 1px dashed #CBD5E1;

            border-radius: var(--radius);

            background: white;
        }


        .empty-icon {
            width: 70px;
            height: 70px;

            display: flex;
            align-items: center;
            justify-content: center;

            margin: auto;

            border-radius: 20px;

            background: #F1F5F9;

            color: #94A3B8;

            font-size: 30px;
        }


        .empty-state h4 {
            margin: 15px 0 5px;

            font-size: 17px;
            font-weight: 800;
        }


        .empty-state p {
            max-width: 450px;

            margin: 0 auto 18px;

            font-size: 12px;

            line-height: 1.6;

            color: var(--text-muted);
        }


        .empty-btn {
            display: inline-flex;
            align-items: center;

            gap: 6px;

            padding: 9px 15px;

            border-radius: 9px;

            background: var(--primary);

            color: white;

            font-size: 11px;
            font-weight: 700;

            text-decoration: none;
        }


        .empty-btn:hover {
            background: var(--primary-dark);

            color: white;
        }

        /* =========================================================
                                                                                                                                           SEARCH TABUNG
                                                                                                                                        ========================================================= */

        .search-tabung-card {
            padding: 20px 22px;

            margin-bottom: 22px;

            border: 1px solid var(--border);

            border-radius: var(--radius);

            background: white;

            box-shadow:
                0 5px 20px rgba(15, 23, 42, .04);
        }


        .search-tabung-title {
            display: flex;
            align-items: center;

            gap: 12px;

            margin-bottom: 16px;
        }


        .search-tabung-icon {
            width: 40px;
            height: 40px;

            display: flex;
            align-items: center;
            justify-content: center;

            border-radius: 11px;

            background: var(--primary-light);

            color: var(--primary);

            font-size: 15px;
        }


        .search-tabung-title h5 {
            margin: 0;

            font-size: 14px;
            font-weight: 800;

            color: var(--text-dark);
        }


        .search-tabung-title span {
            display: block;

            margin-top: 2px;

            font-size: 11px;

            color: var(--text-muted);
        }


        .search-tabung-row {
            display: flex;

            align-items: center;

            gap: 10px;
        }


        .search-input-wrapper {
            position: relative;

            flex: 1;
        }


        .search-input-wrapper>i {
            position: absolute;

            left: 15px;
            top: 50%;

            transform: translateY(-50%);

            color: var(--primary);

            z-index: 2;
        }


        .search-input-wrapper input {
            width: 100%;

            height: 46px;

            padding:
                0 45px 0 42px;

            border: 1px solid var(--border);

            border-radius: 11px;

            background: #F8FAFC;

            color: var(--text-dark);

            font-size: 13px;

            outline: none;

            transition: all .2s ease;
        }


        .search-input-wrapper input::placeholder {
            color: #94A3B8;
        }


        .search-input-wrapper input:focus {
            border-color: var(--primary);

            background: white;

            box-shadow:
                0 0 0 3px rgba(2, 78, 127, .08);
        }


        .clear-search {
            position: absolute;

            right: 10px;
            top: 50%;

            transform: translateY(-50%);

            width: 27px;
            height: 27px;

            display: flex;
            align-items: center;
            justify-content: center;

            border: 0;

            border-radius: 50%;

            background: #E2E8F0;

            color: #64748B;

            font-size: 10px;

            cursor: pointer;

            transition: .2s;
        }


        .clear-search:hover {
            background: #CBD5E1;

            color: #0F172A;
        }


        .search-tabung-btn {
            height: 46px;

            padding: 0 20px;

            display: inline-flex;
            align-items: center;
            justify-content: center;

            gap: 7px;

            border: 0;

            border-radius: 11px;

            background: var(--primary);

            color: white;

            font-size: 12px;
            font-weight: 700;

            cursor: pointer;

            transition: .2s;
        }


        .search-tabung-btn:hover {
            background: var(--primary-dark);

            transform: translateY(-1px);
        }


        .search-result-info {
            display: flex;
            align-items: center;

            flex-wrap: wrap;

            gap: 4px;

            margin-top: 12px;
            padding: 10px 12px;

            border-radius: 9px;

            background: #F0F9FF;

            color: #0369A1;

            font-size: 10px;
        }


        .search-result-info i {
            margin-right: 3px;
        }


        .search-result-info strong {
            color: var(--primary);
        }


        .search-result-info span {
            color: #64748B;
        }


        /* =========================================================
                                                                                                                                                                       TABLET
                                                                                                                                                                    ========================================================= */

        @media (max-width: 1100px) {

            .stats-grid {
                grid-template-columns:
                    repeat(2, minmax(0, 1fr));
            }


            .outlet-grid {
                grid-template-columns:
                    repeat(2, minmax(0, 1fr));
            }

        }


        /* =========================================================
                                                                                                                                                                       MOBILE
                                                                                                                                                                    ========================================================= */

        @media (max-width: 767px) {

            /* =========================================================
                                                                                                                                           SEARCH MOBILE
                                                                                                                                        ========================================================= */

            .search-tabung-card {
                padding: 15px;

                margin-bottom: 18px;

                border-radius: 13px;
            }


            .search-tabung-title {
                align-items: flex-start;

                gap: 9px;

                margin-bottom: 12px;
            }


            .search-tabung-icon {
                width: 34px;
                height: 34px;

                flex-shrink: 0;

                border-radius: 9px;

                font-size: 13px;
            }


            .search-tabung-title h5 {
                font-size: 12px;
            }


            .search-tabung-title span {
                font-size: 9px;

                line-height: 1.4;
            }


            .search-tabung-row {
                display: grid;

                grid-template-columns: 1fr;

                gap: 8px;
            }


            .search-input-wrapper input {
                height: 43px;

                padding-left: 38px;

                font-size: 11px;

                border-radius: 10px;
            }


            .search-input-wrapper>i {
                left: 13px;

                font-size: 12px;
            }


            .clear-search {
                right: 8px;

                width: 25px;
                height: 25px;
            }


            .search-tabung-btn {
                width: 100%;

                height: 42px;

                border-radius: 10px;

                font-size: 10px;
            }


            .search-result-info {
                padding: 9px 10px;

                font-size: 8px;

                line-height: 1.5;
            }

            .monitoring-page {
                padding: 14px 10px 35px;
            }


            /* HEADER */

            .monitoring-header {
                display: block;

                padding: 20px 17px;

                border-radius: 16px;
            }


            .header-content {
                align-items: flex-start;

                gap: 12px;
            }


            .header-icon {
                width: 45px;
                height: 45px;

                border-radius: 12px;

                font-size: 20px;
            }


            .header-label {
                font-size: 8px;
            }


            .header-text h1 {
                font-size: 18px;

                line-height: 1.25;
            }


            .header-text p {
                margin-top: 5px;

                font-size: 10px;

                line-height: 1.5;
            }


            .header-date {
                display: flex;
                align-items: center;

                gap: 6px;

                margin-top: 15px;
                padding-top: 12px;

                text-align: left;

                border-top: 1px solid rgba(255, 255, 255, .15);
            }


            .header-date span,
            .header-date strong,
            .header-date small {
                display: inline-flex;

                margin: 0;
            }


            .header-date span {
                font-size: 9px;
            }


            .header-date strong {
                font-size: 10px;
            }


            .header-date small {
                margin-left: auto;

                font-size: 8px;
            }


            /* ALERT */

            .main-alert {
                align-items: flex-start;

                padding: 15px;

                gap: 10px;
            }


            .alert-left {
                align-items: flex-start;

                gap: 10px;
            }


            .main-alert .alert-icon {
                width: 38px;
                height: 38px;

                border-radius: 10px;

                font-size: 16px;
            }


            .alert-small-title {
                font-size: 8px;
            }


            .main-alert h4 {
                font-size: 12px;

                line-height: 1.4;
            }


            .main-alert p {
                font-size: 9px;

                line-height: 1.5;
            }


            .alert-count {
                display: none;
            }


            /* STATISTICS */

            .stats-grid {
                grid-template-columns:
                    repeat(2, minmax(0, 1fr));

                gap: 9px;

                margin-bottom: 15px;
            }


            .stat-card {
                min-height: 130px;

                padding: 14px;

                border-radius: 13px;
            }


            .stat-label {
                margin-bottom: 6px;

                font-size: 8px;
            }


            .stat-number {
                font-size: 24px;
            }


            .stat-description {
                font-size: 8px;
            }


            .stat-icon {
                width: 36px;
                height: 36px;

                border-radius: 10px;

                font-size: 15px;
            }


            .stat-footer {
                left: 14px;
                right: 14px;
                bottom: 11px;

                padding-top: 8px;

                font-size: 8px;
            }


            /* FILTER */

            .filter-card {
                padding: 15px;

                margin-bottom: 24px;

                border-radius: 13px;
            }


            .filter-title {
                align-items: flex-start;

                margin-bottom: 12px;
            }


            .filter-title-icon {
                width: 34px;
                height: 34px;

                border-radius: 9px;

                font-size: 13px;
            }


            .filter-title h5 {
                font-size: 12px;
            }


            .filter-title span {
                font-size: 9px;

                line-height: 1.4;
            }


            .filter-row {
                display: grid;

                grid-template-columns: 1fr;

                gap: 8px;
            }


            .filter-field label {
                font-size: 9px;
            }


            .input-icon select {
                min-height: 42px;

                font-size: 11px;
            }


            .filter-btn,
            .reset-btn {
                width: 100%;

                min-height: 42px;

                font-size: 10px;
            }


            /* SECTION */

            .section-header {
                align-items: center;

                margin-bottom: 10px;
            }


            .section-label {
                font-size: 8px;
            }


            .section-header h4 {
                font-size: 15px;
            }


            .section-header p {
                max-width: 260px;

                font-size: 9px;

                line-height: 1.5;
            }


            .section-count {
                padding: 5px 8px;

                font-size: 8px;
            }


            /* OUTLET */

            .outlet-grid {
                grid-template-columns: 1fr;

                gap: 9px;

                margin-bottom: 25px;
            }


            .outlet-card {
                padding: 14px;

                border-radius: 13px;
            }


            .outlet-icon {
                width: 34px;
                height: 34px;

                border-radius: 9px;
            }


            .outlet-name {
                font-size: 12px;
            }


            .outlet-total {
                font-size: 20px;
            }


            .outlet-info>div {
                font-size: 8px;
            }


            /* TABLE HEADER */

            .table-section-header {
                align-items: center;
            }


            .table-total {
                padding: 6px 9px;
            }


            .table-total strong {
                font-size: 14px;
            }


            .table-total span {
                font-size: 8px;
            }


            /* HIDE DESKTOP */

            .desktop-table {
                display: none;
            }


            /* SHOW MOBILE */

            .mobile-tube-list {
                display: block;
            }


            /* EMPTY */

            .empty-state {
                padding: 40px 15px;
            }


            .empty-icon {
                width: 55px;
                height: 55px;

                border-radius: 15px;

                font-size: 24px;
            }


            .empty-state h4 {
                font-size: 14px;
            }


            .empty-state p {
                font-size: 10px;
            }

        }


        /* =========================================================
                                                                                                                                                                       VERY SMALL PHONE
                                                                                                                                                                    ========================================================= */

        @media (max-width: 380px) {

            .monitoring-page {
                padding-left: 7px;
                padding-right: 7px;
            }


            .stats-grid {
                gap: 7px;
            }


            .stat-card {
                padding: 11px;
            }


            .stat-icon {
                width: 31px;
                height: 31px;

                font-size: 13px;
            }


            .stat-number {
                font-size: 21px;
            }


            .stat-footer {
                left: 11px;
                right: 11px;

                font-size: 7px;
            }


            .mobile-tube-header {
                padding: 12px;
            }


            .mobile-tube-body {
                padding: 12px;
            }


            .status-badge {
                padding: 5px 7px;

                font-size: 7px;
            }

        }
    </style>


    <div class="container mt-5">

        <div class="monitoring-page">

            {{-- =========================================================
        HEADER
    ========================================================== --}}
            <div class="monitoring-header">

                <div class="header-content">

                    <div class="header-icon">
                        <i class="bi bi-arrow-repeat"></i>
                    </div>

                    <div class="header-text">
                        <span class="header-label">
                            SISTEM MONITORING
                        </span>

                        <h1>
                            Monitoring Perputaran Tabung
                        </h1>

                        <p>
                            Pantau posisi dan lama tabung berada di setiap outlet
                            secara real-time berdasarkan pengiriman yang telah disetujui.
                        </p>
                    </div>

                </div>

                <div class="header-date">

                    <span>
                        <i class="bi bi-calendar3 me-1"></i>
                        Data per tanggal
                    </span>

                    <strong>
                        {{ $tanggalSekarang->translatedFormat('d F Y') }}
                    </strong>

                    <small>
                        <span class="live-dot"></span>
                        Monitoring aktif
                    </small>

                </div>

            </div>


            {{-- =========================================================
        ALERT UTAMA
    ========================================================== --}}
            @if ($totalAlert > 0)
                <div class="main-alert">

                    <div class="alert-left">

                        <div class="alert-icon">
                            <i class="bi bi-exclamation-triangle-fill"></i>
                        </div>

                        <div>

                            <span class="alert-small-title">
                                PERHATIAN
                            </span>

                            <h4>
                                Ada tabung yang perlu segera diputar
                            </h4>

                            <p>
                                Terdapat
                                <strong>{{ $totalAlert }} tabung</strong>
                                yang sudah berada di outlet selama
                                <strong>30 hari atau lebih</strong>.
                            </p>

                        </div>

                    </div>

                    <div class="alert-count">
                        <strong>{{ $totalAlert }}</strong>
                        <span>Tabung Alert</span>
                    </div>

                </div>
            @else
                <div class="main-alert success-alert">

                    <div class="alert-left">

                        <div class="alert-icon">
                            <i class="bi bi-check-circle-fill"></i>
                        </div>

                        <div>

                            <span class="alert-small-title">
                                KONDISI AMAN
                            </span>

                            <h4>
                                Perputaran tabung berjalan dengan baik
                            </h4>

                            <p>
                                Tidak ada tabung yang berada di outlet selama
                                30 hari atau lebih.
                            </p>

                        </div>

                    </div>

                    <div class="alert-count">
                        <i class="bi bi-shield-check"></i>
                        <span>Aman</span>
                    </div>

                </div>
            @endif


            {{-- =========================================================
        STATISTIK
    ========================================================== --}}
            <div class="stats-grid">

                {{-- TOTAL --}}
                <div class="stat-card stat-blue">

                    <div class="stat-top">

                        <div>
                            <span class="stat-label">
                                TOTAL TABUNG
                            </span>

                            <div class="stat-number">
                                {{ $totalTabung }}
                            </div>

                            <span class="stat-description">
                                Sedang berada di outlet
                            </span>
                        </div>

                        <div class="stat-icon">
                            <i class="bi bi-box-seam-fill"></i>
                        </div>

                    </div>

                    <div class="stat-footer">
                        <i class="bi bi-activity"></i>
                        Tabung aktif di outlet
                    </div>

                </div>


                {{-- ALERT --}}
                <div class="stat-card stat-red">

                    <div class="stat-top">

                        <div>
                            <span class="stat-label">
                                ALERT
                            </span>

                            <div class="stat-number">
                                {{ $totalAlert }}
                            </div>

                            <span class="stat-description">
                                30 hari atau lebih
                            </span>
                        </div>

                        <div class="stat-icon">
                            <i class="bi bi-exclamation-triangle-fill"></i>
                        </div>

                    </div>

                    <div class="stat-footer">
                        <i class="bi bi-arrow-up-right"></i>
                        Perlu segera diputar
                    </div>

                </div>


                {{-- PERINGATAN --}}
                <div class="stat-card stat-orange">

                    <div class="stat-top">

                        <div>
                            <span class="stat-label">
                                PERHATIAN
                            </span>

                            <div class="stat-number">
                                {{ $totalPeringatan }}
                            </div>

                            <span class="stat-description">
                                20 sampai 29 hari
                            </span>
                        </div>

                        <div class="stat-icon">
                            <i class="bi bi-clock-history"></i>
                        </div>

                    </div>

                    <div class="stat-footer">
                        <i class="bi bi-hourglass-split"></i>
                        Mendekati batas waktu
                    </div>

                </div>


                {{-- NORMAL --}}
                <div class="stat-card stat-green">

                    <div class="stat-top">

                        <div>
                            <span class="stat-label">
                                NORMAL
                            </span>

                            <div class="stat-number">
                                {{ $totalNormal }}
                            </div>

                            <span class="stat-description">
                                Kurang dari 20 hari
                            </span>
                        </div>

                        <div class="stat-icon">
                            <i class="bi bi-check-circle-fill"></i>
                        </div>

                    </div>

                    <div class="stat-footer">
                        <i class="bi bi-shield-check"></i>
                        Kondisi normal
                    </div>

                </div>

            </div>


            {{-- =========================================================
        FILTER
    ========================================================== --}}
            <div class="filter-card">

                <div class="filter-title">

                    <div class="filter-title-icon">
                        <i class="bi bi-funnel-fill"></i>
                    </div>

                    <div>
                        <h5>
                            Filter Monitoring
                        </h5>

                        <span>
                            Pilih outlet untuk melihat kondisi tabung secara lebih spesifik.
                        </span>
                    </div>

                </div>


                <form method="GET" action="{{ route('monitoring.tabung') }}">

                    <div class="filter-row">

                        <div class="filter-field">

                            <label for="outlet_id">
                                Outlet
                            </label>

                            <div class="input-icon">

                                <i class="bi bi-shop"></i>

                                <select id="outlet_id" name="outlet_id">

                                    <option value="">
                                        Semua Outlet
                                    </option>

                                    @foreach ($outlets as $outlet)
                                        <option value="{{ $outlet->id }}"
                                            {{ request('outlet_id') == $outlet->id ? 'selected' : '' }}>

                                            {{ $outlet->nama_outlet }}

                                        </option>
                                    @endforeach

                                </select>

                            </div>

                        </div>


                        <button type="submit" class="filter-btn">

                            <i class="bi bi-search"></i>

                            <span>
                                Tampilkan Data
                            </span>

                        </button>


                        @if (request('outlet_id'))
                            <a href="{{ route('monitoring.tabung') }}" class="reset-btn">

                                <i class="bi bi-arrow-counterclockwise"></i>

                                Reset

                            </a>
                        @endif

                    </div>

                </form>

            </div>

            {{-- =========================================================
    SEARCH TABUNG
========================================================= --}}
            <div class="search-tabung-card">

                <div class="search-tabung-title">

                    <div class="search-tabung-icon">
                        <i class="bi bi-search"></i>
                    </div>

                    <div>
                        <h5>
                            Cari Tabung
                        </h5>

                        <span>
                            Masukkan kode tabung untuk melihat posisi terakhirnya.
                        </span>
                    </div>

                </div>


                <form method="GET" action="{{ route('monitoring.tabung') }}" id="formSearchTabung">

                    {{-- Pertahankan filter outlet --}}
                    @if (request('outlet_id'))
                        <input type="hidden" name="outlet_id" value="{{ request('outlet_id') }}">
                    @endif


                    <div class="search-tabung-row">

                        <div class="search-input-wrapper">

                            <i class="bi bi-upc-scan"></i>

                            <input type="text" name="cari_tabung" id="cari_tabung" value="{{ request('cari_tabung') }}"
                                placeholder="Contoh: NP220" autocomplete="off">

                            @if (request('cari_tabung'))
                                <button type="button" class="clear-search" id="clearSearch">

                                    <i class="bi bi-x-lg"></i>

                                </button>
                            @endif

                        </div>


                        <button type="submit" class="search-tabung-btn">

                            <i class="bi bi-search"></i>

                            <span>
                                Cari Tabung
                            </span>

                        </button>

                    </div>

                </form>


                @if (request('cari_tabung'))
                    <div class="search-result-info">

                        <i class="bi bi-info-circle-fill"></i>

                        Menampilkan hasil pencarian untuk:

                        <strong>
                            "{{ request('cari_tabung') }}"
                        </strong>

                        <span>
                            — {{ $tabungDiOutlet->count() }} tabung ditemukan
                        </span>

                    </div>
                @endif

            </div>


            {{-- =========================================================
        RINGKASAN OUTLET
    ========================================================== --}}
            @if ($statistikOutlet->count())

                <div class="section-header">

                    <div>

                        <span class="section-label">
                            OVERVIEW
                        </span>

                        <h4>
                            Kondisi Per Outlet
                        </h4>

                    </div>

                    <span class="section-count">
                        {{ $statistikOutlet->count() }} Outlet
                    </span>

                </div>


                <div class="outlet-grid">

                    @foreach ($statistikOutlet as $stat)
                        <div class="outlet-card
                    {{ $stat['alert'] > 0 ? 'has-alert' : 'is-safe' }}">

                            <div class="outlet-card-top">

                                <div class="outlet-icon">
                                    <i class="bi bi-shop"></i>
                                </div>

                                @if ($stat['alert'] > 0)
                                    <span class="outlet-status status-danger">
                                        <i class="bi bi-exclamation-circle-fill"></i>
                                        {{ $stat['alert'] }} Alert
                                    </span>
                                @else
                                    <span class="outlet-status status-safe">
                                        <i class="bi bi-check-circle-fill"></i>
                                        Aman
                                    </span>
                                @endif

                            </div>


                            <div class="outlet-name">
                                {{ $stat['nama_outlet'] }}
                            </div>

                            <div class="outlet-total">
                                {{ $stat['total'] }}
                                <span>tabung</span>
                            </div>


                            <div class="outlet-progress">

                                @php
                                    $total = max($stat['total'], 1);

                                    $alertPercent = ($stat['alert'] / $total) * 100;

                                    $warningPercent = ($stat['peringatan'] / $total) * 100;

                                    $normalPercent = ($stat['normal'] / $total) * 100;
                                @endphp

                                <div class="progress-alert" style="width: {{ $alertPercent }}%;">
                                </div>

                                <div class="progress-warning" style="width: {{ $warningPercent }}%;">
                                </div>

                                <div class="progress-normal" style="width: {{ $normalPercent }}%;">
                                </div>

                            </div>


                            <div class="outlet-info">

                                <div>
                                    <span class="dot dot-danger"></span>
                                    <span>Alert</span>
                                    <strong>{{ $stat['alert'] }}</strong>
                                </div>

                                <div>
                                    <span class="dot dot-warning"></span>
                                    <span>Perhatian</span>
                                    <strong>{{ $stat['peringatan'] }}</strong>
                                </div>

                                <div>
                                    <span class="dot dot-success"></span>
                                    <span>Normal</span>
                                    <strong>{{ $stat['normal'] }}</strong>
                                </div>

                            </div>

                        </div>
                    @endforeach

                </div>

            @endif


            {{-- =========================================================
        DAFTAR TABUNG
    ========================================================== --}}
            <div class="section-header table-section-header">

                <div>

                    <span class="section-label">
                        DETAIL MONITORING
                    </span>

                    <h4>
                        Tabung Yang Berada di Outlet
                    </h4>

                    <p>
                        Hanya pengiriman dengan status
                        <strong>disetujui</strong>
                        yang diperhitungkan.
                    </p>

                </div>

                <div class="table-total">

                    <strong>
                        {{ $tabungDiOutlet->count() }}
                    </strong>

                    <span>
                        Tabung
                    </span>

                </div>

            </div>


            @if ($tabungDiOutlet->count())

                {{-- =====================================================
            DESKTOP TABLE
        ====================================================== --}}
                <div class="desktop-table">

                    <div class="table-card">

                        <div class="table-responsive">

                            <table class="monitoring-table">

                                <thead>

                                    <tr>

                                        <th>
                                            #
                                        </th>

                                        <th>
                                            Tabung
                                        </th>

                                        <th>
                                            Outlet
                                        </th>

                                        <th>
                                            Tanggal Masuk
                                        </th>

                                        <th>
                                            Durasi
                                        </th>

                                        <th>
                                            Status
                                        </th>

                                        <th>
                                            Aksi
                                        </th>

                                    </tr>

                                </thead>

                                <tbody>

                                    @foreach ($tabungDiOutlet as $index => $item)
                                        <tr>

                                            <td class="number-column">
                                                {{ $index + 1 }}
                                            </td>


                                            <td>

                                                <div class="tube-code">

                                                    <div class="tube-icon">
                                                        <i class="bi bi-upc-scan"></i>
                                                    </div>

                                                    <div>
                                                        <strong>
                                                            {{ $item['kode_tabung'] }}
                                                        </strong>

                                                        <small>
                                                            ID Tabung
                                                        </small>
                                                    </div>

                                                </div>


                                                {{-- =====================================================
        CATATAN KHUSUS
    ====================================================== --}}

                                                @php
                                                    $key = $item['kode_tabung'] . '|' . $item['outlet_id'];
                                                    $catatanTabung = $catatanKhusus[$key] ?? collect();
                                                @endphp


                                                @if ($catatanTabung->count())
                                                    <div class="catatan-khusus-wrapper">

                                                        @foreach ($catatanTabung as $catatan)
                                                            <div class="catatan-khusus-item">

                                                                <div class="catatan-khusus-head">

                                                                    <div class="catatan-khusus-title">

                                                                        <i class="bi bi-sticky-fill"></i>

                                                                        <span>
                                                                            CATATAN KHUSUS
                                                                        </span>

                                                                    </div>


                                                                    @if (in_array(auth()->user()->role, ['admin', 'spv']))
                                                                        <form
                                                                            action="{{ route('catatan-khusus-tabung.destroy', $catatan->id) }}"
                                                                            method="POST" class="form-hapus-catatan">

                                                                            @csrf
                                                                            @method('DELETE')

                                                                            <button type="submit"
                                                                                class="catatan-khusus-delete"
                                                                                title="Hapus Catatan">

                                                                                <i class="bi bi-trash3"></i>

                                                                            </button>

                                                                        </form>
                                                                    @endif

                                                                </div>


                                                                <p class="catatan-khusus-text">
                                                                    {{ $catatan->catatan }}
                                                                </p>


                                                                <div class="catatan-khusus-meta">

                                                                    <i class="bi bi-person-circle"></i>

                                                                    <span>
                                                                        {{ $catatan->user->name ?? '-' }}
                                                                    </span>

                                                                    <span>•</span>

                                                                    <span>
                                                                        {{ $catatan->created_at->format('d/m/Y H:i') }}
                                                                    </span>

                                                                </div>

                                                            </div>
                                                        @endforeach

                                                    </div>
                                                @endif

                                            </td>


                                            <td>

                                                <div class="outlet-table">

                                                    <i class="bi bi-shop"></i>

                                                    <span>
                                                        {{ $item['outlet']->nama_outlet ?? '-' }}
                                                    </span>

                                                </div>

                                            </td>


                                            <td>

                                                <div class="date-table">

                                                    <strong>
                                                        {{ $item['tanggal']->translatedFormat('d F Y') }}
                                                    </strong>

                                                    <small>
                                                        Tanggal masuk
                                                    </small>

                                                </div>

                                            </td>


                                            <td>

                                                <div class="duration">

                                                    <strong>
                                                        {{ $item['umur_hari'] }}
                                                    </strong>

                                                    <span>
                                                        hari
                                                    </span>

                                                </div>

                                            </td>

                                            <td>

                                                @if ($item['status_alert'] === 'alert')
                                                    <span class="status-badge badge-danger">

                                                        <i class="bi bi-exclamation-triangle-fill"></i>

                                                        ALERT

                                                    </span>
                                                @elseif($item['status_alert'] === 'peringatan')
                                                    <span class="status-badge badge-warning">

                                                        <i class="bi bi-clock-fill"></i>

                                                        PERHATIAN

                                                    </span>
                                                @else
                                                    <span class="status-badge badge-success">

                                                        <i class="bi bi-check-circle-fill"></i>

                                                        NORMAL

                                                    </span>
                                                @endif

                                            </td>


                                            {{-- =====================================================
    AKSI
====================================================== --}}
                                            <td>

                                                @if ($item['status_alert'] === 'alert' && in_array(auth()->user()->role, ['admin', 'spv']))
                                                    <button type="button" class="btn-catatan-khusus"
                                                        data-bs-toggle="modal" data-bs-target="#modalCatatanKhusus"
                                                        data-kode="{{ $item['kode_tabung'] }}"
                                                        data-outlet-id="{{ $item['outlet_id'] }}"
                                                        data-outlet="{{ $item['outlet']->nama_outlet ?? '-' }}">

                                                        <i class="bi bi-journal-plus"></i>

                                                        <span>Catatan</span>

                                                    </button>
                                                @else
                                                    <span style="color:#CBD5E1;">—</span>
                                                @endif

                                            </td>

                                        </tr>
                                    @endforeach

                                </tbody>

                            </table>

                        </div>

                    </div>

                </div>


                {{-- =====================================================
            MOBILE CARDS
        ====================================================== --}}
                <div class="mobile-tube-list">

                    @foreach ($tabungDiOutlet as $index => $item)
                        <div
                            class="mobile-tube-card
                    {{ $item['status_alert'] === 'alert'
                        ? 'tube-alert'
                        : ($item['status_alert'] === 'peringatan'
                            ? 'tube-warning'
                            : 'tube-normal') }}">

                            <div class="mobile-tube-header">

                                <div class="mobile-tube-code">

                                    <div class="tube-icon">
                                        <i class="bi bi-upc-scan"></i>
                                    </div>

                                    <div>

                                        <span>
                                            TABUNG #{{ $index + 1 }}
                                        </span>

                                        <strong>
                                            {{ $item['kode_tabung'] }}
                                        </strong>

                                    </div>

                                </div>


                                @if ($item['status_alert'] === 'alert')
                                    <span class="status-badge badge-danger">
                                        <i class="bi bi-exclamation-triangle-fill"></i>
                                        ALERT
                                    </span>
                                @elseif($item['status_alert'] === 'peringatan')
                                    <span class="status-badge badge-warning">
                                        <i class="bi bi-clock-fill"></i>
                                        PERHATIAN
                                    </span>
                                @else
                                    <span class="status-badge badge-success">
                                        <i class="bi bi-check-circle-fill"></i>
                                        NORMAL
                                    </span>
                                @endif

                            </div>


                            <div class="mobile-tube-body">

                                <div class="mobile-info">

                                    <span>
                                        <i class="bi bi-shop"></i>
                                        Outlet
                                    </span>

                                    <strong>
                                        {{ $item['outlet']->nama_outlet ?? '-' }}
                                    </strong>

                                </div>


                                <div class="mobile-info">

                                    <span>
                                        <i class="bi bi-calendar3"></i>
                                        Tanggal Masuk
                                    </span>

                                    <strong>
                                        {{ $item['tanggal']->translatedFormat('d F Y') }}
                                    </strong>

                                </div>


                                <div class="mobile-duration">

                                    <div>

                                        <span>
                                            Lama di Outlet
                                        </span>

                                        <strong>
                                            {{ $item['umur_hari'] }}
                                            <small>hari</small>
                                        </strong>

                                    </div>

                                    @if ($item['status_alert'] === 'alert')
                                        <i class="bi bi-exclamation-triangle-fill"></i>
                                    @elseif($item['status_alert'] === 'peringatan')
                                        <i class="bi bi-clock-fill"></i>
                                    @else
                                        <i class="bi bi-check-circle-fill"></i>
                                    @endif

                                </div>

                                @php
                                    $key = $item['kode_tabung'] . '|' . $item['outlet_id'];
                                    $catatanTabung = $catatanKhusus[$key] ?? collect();
                                @endphp


                                @if ($catatanTabung->count())
                                    <div class="mobile-catatan-wrapper">

                                        <div class="mobile-catatan-title">

                                            <i class="bi bi-sticky-fill"></i>

                                            Catatan Khusus

                                        </div>


                                        @foreach ($catatanTabung as $catatan)
                                            <div class="mobile-catatan-item">

                                                <div class="d-flex justify-content-between align-items-start gap-2">

                                                    <p class="mobile-catatan-text">

                                                        {{ $catatan->catatan }}

                                                    </p>


                                                    @if (in_array(auth()->user()->role, ['admin', 'spv']))
                                                        <form
                                                            action="{{ route('catatan-khusus-tabung.destroy', $catatan->id) }}"
                                                            method="POST" class="form-hapus-catatan">

                                                            @csrf
                                                            @method('DELETE')

                                                            <button type="submit" class="catatan-khusus-delete"
                                                                title="Hapus Catatan">

                                                                <i class="bi bi-trash3"></i>

                                                            </button>

                                                        </form>
                                                    @endif

                                                </div>


                                                <div class="mobile-catatan-meta">

                                                    <i class="bi bi-person-circle"></i>

                                                    {{ $catatan->user->name ?? '-' }}

                                                    ·

                                                    {{ $catatan->created_at->format('d/m/Y H:i') }}

                                                </div>

                                            </div>
                                        @endforeach

                                    </div>
                                @endif

                                @if ($item['status_alert'] === 'alert' && in_array(auth()->user()->role, ['admin', 'spv']))
                                    <button type="button" class="mobile-catatan-button" data-bs-toggle="modal"
                                        data-bs-target="#modalCatatanKhusus" data-kode="{{ $item['kode_tabung'] }}"
                                        data-outlet-id="{{ $item['outlet_id'] }}"
                                        data-outlet="{{ $item['outlet']->nama_outlet ?? '-' }}">

                                        <i class="bi bi-journal-plus"></i>

                                        Tambahkan Catatan Khusus

                                    </button>
                                @endif
                            </div>

                        </div>
                    @endforeach

                </div>
            @else
                {{-- =====================================================
            EMPTY STATE
        ====================================================== --}}
                <div class="empty-state">

                    <div class="empty-icon">
                        <i class="bi bi-box-seam"></i>
                    </div>

                    <h4>
                        Tidak Ada Tabung
                    </h4>

                    <p>
                        Belum ada tabung yang sedang berada di outlet
                        berdasarkan pengiriman yang telah disetujui.
                    </p>

                    @if (request('outlet_id'))
                        <a href="{{ route('monitoring.tabung') }}" class="empty-btn">

                            <i class="bi bi-arrow-counterclockwise"></i>
                            Lihat Semua Outlet

                        </a>
                    @endif

                </div>

            @endif

        </div>

    </div>

    @if (in_array(auth()->user()->role, ['admin', 'spv']))
        <div class="modal fade" id="modalCatatanKhusus" tabindex="-1" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered">

                <div class="modal-content border-0 shadow">

                    <div class="modal-header">
                        <div>
                            <h5 class="modal-title">
                                <i class="bi bi-journal-text me-2"></i>
                                Catatan Khusus Tabung
                            </h5>

                            <small class="text-muted">
                                Tambahkan informasi khusus untuk tabung.
                            </small>
                        </div>

                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                    </div>

                    <form action="{{ route('catatan-khusus-tabung.store') }}" method="POST" id="formCatatanKhusus">

                        @csrf

                        <div class="modal-body">

                            <div class="mb-3">
                                <label class="form-label">
                                    Kode Tabung
                                </label>

                                <input type="text" name="kode_tabung" id="modalKodeTabung" class="form-control"
                                    readonly>
                            </div>

                            <div class="mb-3">
                                <label class="form-label">
                                    Outlet
                                </label>

                                <input type="text" id="modalNamaOutlet" class="form-control" readonly>

                                <input type="hidden" name="outlet_id" id="modalOutletId">
                            </div>

                            <div class="mb-3">
                                <label class="form-label">
                                    Catatan Khusus
                                </label>

                                <textarea name="catatan" id="inputCatatanKhusus" class="form-control" rows="5"
                                    placeholder="Contoh: Tabung mengalami kerusakan ringan pada bagian valve..." required></textarea>
                            </div>

                        </div>

                        <div class="modal-footer">

                            <button type="button" class="btn btn-light" data-bs-dismiss="modal">
                                Batal
                            </button>

                            <button type="submit" class="btn btn-primary" id="btnSimpanCatatan">
                                <i class="bi bi-save me-1"></i>
                                Simpan Catatan
                            </button>

                        </div>

                    </form>

                </div>
            </div>
        </div>
    @endif

    <style>
        #modalCatatanKhusus {
            z-index: 1060 !important;
        }

        #modalCatatanKhusus .modal-dialog,
        #modalCatatanKhusus .modal-content,
        #modalCatatanKhusus .modal-body,
        #modalCatatanKhusus form,
        #modalCatatanKhusus textarea,
        #modalCatatanKhusus input,
        #modalCatatanKhusus button {
            position: relative;
        }

        #modalCatatanKhusus textarea,
        #modalCatatanKhusus input {
            z-index: 10;
            pointer-events: auto !important;
        }

        #modalCatatanKhusus .modal-body {
            position: relative;
            z-index: 5;
        }

        /* =========================================================
                                                                       CATATAN KHUSUS TABUNG - TEMA KUNING
                                                                    ========================================================= */

        .catatan-khusus-wrapper {
            margin-top: 10px;
            display: flex;
            flex-direction: column;
            gap: 7px;
        }

        .catatan-khusus-item {
            position: relative;

            padding: 10px 12px;

            border: 1px solid #FDE68A;
            border-left: 4px solid #F59E0B;

            border-radius: 10px;

            background: linear-gradient(135deg,
                    #FFFBEB 0%,
                    #FFFDF5 100%);

            box-shadow:
                0 3px 10px rgba(245, 158, 11, .08);
        }

        .catatan-khusus-head {
            display: flex;
            align-items: center;
            justify-content: space-between;

            gap: 8px;

            margin-bottom: 5px;
        }

        .catatan-khusus-title {
            display: flex;
            align-items: center;

            gap: 6px;

            color: #B45309;

            font-size: 10px;
            font-weight: 800;

            letter-spacing: .3px;
        }

        .catatan-khusus-title i {
            font-size: 12px;
            color: #F59E0B;
        }

        .catatan-khusus-text {
            margin: 0;

            color: #78350F;

            font-size: 10px;
            line-height: 1.5;

            word-break: break-word;
        }

        .catatan-khusus-meta {
            display: flex;
            align-items: center;

            gap: 5px;

            margin-top: 7px;

            color: #A16207;

            font-size: 8px;
        }

        .catatan-khusus-meta i {
            color: #D97706;
        }


        /* =========================================================
                                                                       DELETE BUTTON
                                                                    ========================================================= */

        .catatan-khusus-delete {
            width: 25px;
            height: 25px;

            display: inline-flex;
            align-items: center;
            justify-content: center;

            flex-shrink: 0;

            border: 1px solid #FECACA;
            border-radius: 7px;

            background: #FFF5F5;
            color: #DC2626;

            font-size: 10px;

            cursor: pointer;

            transition: all .2s ease;
        }

        .catatan-khusus-delete:hover {
            background: #FEE2E2;

            border-color: #FCA5A5;

            color: #B91C1C;

            transform: translateY(-1px);
        }


        /* =========================================================
                                                                       BUTTON CATATAN
                                                                    ========================================================= */

        .btn-catatan-khusus {
            display: inline-flex;
            align-items: center;
            justify-content: center;

            gap: 6px;

            min-height: 34px;

            padding: 0 12px;

            border: 1px solid #FCD34D;
            border-radius: 9px;

            background: #FEF3C7;
            color: #B45309;

            font-size: 10px;
            font-weight: 800;

            white-space: nowrap;

            cursor: pointer;

            transition: all .2s ease;
        }

        .btn-catatan-khusus:hover {
            background: #F59E0B;

            border-color: #F59E0B;

            color: white;

            transform: translateY(-1px);

            box-shadow:
                0 5px 12px rgba(245, 158, 11, .20);
        }

        .btn-catatan-khusus i {
            font-size: 12px;
        }


        /* =========================================================
                                                                       MOBILE CATATAN
                                                                    ========================================================= */

        .mobile-catatan-wrapper {
            margin-top: 12px;
        }

        .mobile-catatan-title {
            display: flex;
            align-items: center;

            gap: 6px;

            margin-bottom: 7px;

            color: #B45309;

            font-size: 9px;
            font-weight: 800;
        }

        .mobile-catatan-title i {
            color: #F59E0B;
        }

        .mobile-catatan-item {
            padding: 10px;

            border: 1px solid #FDE68A;
            border-left: 4px solid #F59E0B;

            border-radius: 9px;

            background: linear-gradient(135deg,
                    #FFFBEB,
                    #FFFDF5);

            box-shadow:
                0 3px 10px rgba(245, 158, 11, .07);
        }

        .mobile-catatan-item+.mobile-catatan-item {
            margin-top: 6px;
        }

        .mobile-catatan-text {
            margin: 0;

            color: #78350F;

            font-size: 9px;
            line-height: 1.5;

            word-break: break-word;
        }

        .mobile-catatan-meta {
            margin-top: 6px;

            color: #A16207;

            font-size: 7px;
        }


        /* =========================================================
                                                                       MOBILE BUTTON
                                                                    ========================================================= */

        .mobile-catatan-button {
            width: 100%;

            min-height: 38px;

            margin-top: 10px;

            display: flex;
            align-items: center;
            justify-content: center;

            gap: 6px;

            border: 1px solid #FCD34D;
            border-radius: 9px;

            background: #FEF3C7;
            color: #B45309;

            font-size: 9px;
            font-weight: 800;

            cursor: pointer;

            transition: all .2s ease;
        }

        .mobile-catatan-button:hover {
            background: #F59E0B;

            border-color: #F59E0B;

            color: white;
        }

        .mobile-catatan-button i {
            color: #D97706;
        }

        .mobile-catatan-button:hover i {
            color: white;
        }


        /* =========================================================
                                                                                           MODAL CATATAN KHUSUS
                                                                                        ========================================================= */

        #modalCatatanKhusus .modal-dialog {
            max-width: 500px;
        }

        #modalCatatanKhusus .modal-content {
            overflow: hidden;

            border-radius: 18px !important;

            border: 1px solid var(--border) !important;

            box-shadow:
                0 20px 50px rgba(15, 23, 42, .15) !important;
        }

        #modalCatatanKhusus .modal-header {
            position: relative;

            padding: 20px 22px;

            border: 0;

            background:
                linear-gradient(135deg,
                    #024E7F 0%,
                    #05699F 60%,
                    #0284C7 100%);

            color: white;
        }

        #modalCatatanKhusus .modal-header::after {
            content: "";

            position: absolute;

            width: 100px;
            height: 100px;

            right: -25px;
            top: -55px;

            border-radius: 50%;

            background: rgba(255, 255, 255, .08);
        }

        #modalCatatanKhusus .modal-title {
            position: relative;
            z-index: 2;

            margin: 0;

            color: white;

            font-size: 15px;
            font-weight: 800;
        }

        #modalCatatanKhusus .modal-title i {
            color: rgba(255, 255, 255, .9);
        }

        #modalCatatanKhusus .modal-header small {
            position: relative;
            z-index: 2;

            display: block;

            margin-top: 4px;

            color: rgba(255, 255, 255, .75) !important;

            font-size: 10px;
        }

        #modalCatatanKhusus .btn-close {
            position: relative;
            z-index: 5;

            opacity: 1;

            filter: brightness(0) invert(1);
        }

        #modalCatatanKhusus .modal-body {
            padding: 22px;
        }

        #modalCatatanKhusus .form-label {
            margin-bottom: 7px;

            color: var(--text-dark);

            font-size: 11px;
            font-weight: 800;
        }

        #modalCatatanKhusus .form-control {
            min-height: 43px;

            border: 1px solid var(--border);
            border-radius: 10px;

            background: #F8FAFC;

            color: var(--text-dark);

            font-size: 12px;

            box-shadow: none;

            transition: all .2s ease;
        }

        #modalCatatanKhusus .form-control:focus {
            border-color: var(--primary);

            background: white;

            box-shadow:
                0 0 0 3px rgba(2, 78, 127, .08);
        }

        #modalCatatanKhusus textarea.form-control {
            min-height: 120px;

            resize: vertical;

            line-height: 1.6;
        }

        #modalCatatanKhusus .modal-footer {
            padding: 14px 22px;

            border-top: 1px solid #F1F5F9;

            background: #FAFCFE;
        }

        #modalCatatanKhusus .btn-light {
            min-height: 38px;

            padding: 0 16px;

            border: 1px solid var(--border);
            border-radius: 9px;

            font-size: 10px;
            font-weight: 700;
        }

        #modalCatatanKhusus .btn-primary {
            min-height: 38px;

            padding: 0 17px;

            border: 0;
            border-radius: 9px;

            background: var(--primary);

            font-size: 10px;
            font-weight: 800;
        }

        #modalCatatanKhusus .btn-primary:hover {
            background: var(--primary-dark);
        }


        /* =========================================================
                                                                                           MOBILE CATATAN
                                                                                        ========================================================= */

        .mobile-catatan-wrapper {
            margin-top: 12px;
        }

        .mobile-catatan-title {
            display: flex;
            align-items: center;
            gap: 6px;

            margin-bottom: 7px;

            color: var(--primary);

            font-size: 9px;
            font-weight: 800;
        }

        .mobile-catatan-item {
            padding: 10px;

            border: 1px solid #DBEAFE;
            border-left: 3px solid var(--primary);

            border-radius: 9px;

            background: #F8FBFD;
        }

        .mobile-catatan-item+.mobile-catatan-item {
            margin-top: 6px;
        }

        .mobile-catatan-text {
            margin: 0;

            color: #475569;

            font-size: 9px;
            line-height: 1.5;

            word-break: break-word;
        }

        .mobile-catatan-meta {
            margin-top: 6px;

            color: #94A3B8;

            font-size: 7px;
        }


        /* =========================================================
                                                                                           MOBILE BUTTON
                                                                                        ========================================================= */

        .mobile-catatan-button {
            width: 100%;

            min-height: 38px;

            margin-top: 10px;

            display: flex;
            align-items: center;
            justify-content: center;

            gap: 6px;

            border: 1px solid #BFDBFE;
            border-radius: 9px;

            background: #EFF6FF;
            color: var(--primary);

            font-size: 9px;
            font-weight: 800;

            transition: .2s;
        }

        .mobile-catatan-button:hover {
            background: var(--primary);
            color: white;
        }


        /* =========================================================
                                                                                           RESPONSIVE MODAL
                                                                                        ========================================================= */

        @media (max-width: 767px) {

            #modalCatatanKhusus .modal-dialog {
                margin: 12px;
            }

            #modalCatatanKhusus .modal-header {
                padding: 17px;
            }

            #modalCatatanKhusus .modal-body {
                padding: 17px;
            }

            #modalCatatanKhusus .modal-footer {
                padding: 12px 17px;
            }

            #modalCatatanKhusus .modal-title {
                font-size: 13px;
            }

            #modalCatatanKhusus .modal-header small {
                font-size: 8px;
            }

            #modalCatatanKhusus .form-label {
                font-size: 9px;
            }

            #modalCatatanKhusus .form-control {
                min-height: 40px;
                font-size: 10px;
            }

            #modalCatatanKhusus textarea.form-control {
                min-height: 105px;
            }

            #modalCatatanKhusus .btn-light,
            #modalCatatanKhusus .btn-primary {
                min-height: 36px;
                font-size: 9px;
            }

        }
    </style>

    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <script>
        document.addEventListener('DOMContentLoaded', function() {

            /* =========================================================
               ELEMENT
            ========================================================= */

            const modal = document.getElementById('modalCatatanKhusus');
            const formCatatan = document.getElementById('formCatatanKhusus');

            const kodeInput = document.getElementById('modalKodeTabung');
            const outletIdInput = document.getElementById('modalOutletId');
            const outletInput = document.getElementById('modalNamaOutlet');
            const catatanInput = document.getElementById('inputCatatanKhusus');
            const btnSimpan = document.getElementById('btnSimpanCatatan');


            /* =========================================================
               BUKA MODAL CATATAN
            ========================================================= */

            if (modal) {

                modal.addEventListener('show.bs.modal', function(event) {

                    const button = event.relatedTarget;

                    if (!button) {
                        return;
                    }

                    const kode = button.getAttribute('data-kode') || '';
                    const outletId = button.getAttribute('data-outlet-id') || '';
                    const outlet = button.getAttribute('data-outlet') || '';

                    if (kodeInput) {
                        kodeInput.value = kode;
                    }

                    if (outletIdInput) {
                        outletIdInput.value = outletId;
                    }

                    if (outletInput) {
                        outletInput.value = outlet;
                    }

                    /* Reset textarea setiap modal dibuka */
                    if (catatanInput) {
                        catatanInput.value = '';

                        setTimeout(function() {
                            catatanInput.focus();
                        }, 300);
                    }

                    /* Reset tombol */
                    if (btnSimpan) {
                        btnSimpan.disabled = false;

                        btnSimpan.innerHTML = `
                    <i class="bi bi-save me-1"></i>
                    Simpan Catatan
                `;
                    }

                });

            }


            /* =========================================================
               SUBMIT CATATAN
            ========================================================= */

            if (formCatatan) {

                formCatatan.addEventListener('submit', function(e) {

                    e.preventDefault();

                    const form = this;

                    const kode = kodeInput ?
                        kodeInput.value.trim() :
                        '';

                    const outlet = outletInput ?
                        outletInput.value.trim() :
                        '';

                    const catatan = catatanInput ?
                        catatanInput.value.trim() :
                        '';


                    /* =====================================================
                       VALIDASI
                    ===================================================== */

                    if (!kode) {

                        Swal.fire({
                            icon: 'error',
                            title: 'Kode Tabung Tidak Ditemukan',
                            text: 'Silakan tutup modal dan pilih tabung kembali.',
                            confirmButtonColor: '#024E7F'
                        });

                        return;
                    }


                    if (!outletIdInput || !outletIdInput.value) {

                        Swal.fire({
                            icon: 'error',
                            title: 'Outlet Tidak Ditemukan',
                            text: 'Data outlet tabung tidak ditemukan.',
                            confirmButtonColor: '#024E7F'
                        });

                        return;
                    }


                    if (!catatan) {

                        Swal.fire({
                            icon: 'warning',
                            title: 'Catatan Masih Kosong',
                            text: 'Silakan isi Catatan Khusus terlebih dahulu.',
                            confirmButtonText: 'Isi Catatan',
                            confirmButtonColor: '#F59E0B'
                        }).then(function() {

                            if (catatanInput) {
                                catatanInput.focus();
                            }

                        });

                        return;
                    }


                    /* =====================================================
                       KONFIRMASI SIMPAN
                    ===================================================== */

                    Swal.fire({

                        icon: 'question',

                        title: 'Simpan Catatan Khusus?',

                        html: `
                    <div style="
                        font-size:13px;
                        line-height:1.7;
                        color:#64748B;
                        text-align:left;
                    ">

                        <div style="
                            padding:12px;
                            margin-bottom:10px;
                            border-radius:10px;
                            background:#FFF8E7;
                            border:1px solid #FCD34D;
                        ">

                            <div style="
                                font-size:10px;
                                font-weight:800;
                                color:#B45309;
                                margin-bottom:4px;
                                text-transform:uppercase;
                            ">
                                CATATAN KHUSUS
                            </div>

                            <div style="
                                color:#475569;
                                word-break:break-word;
                            ">
                                ${escapeHtml(catatan)}
                            </div>

                        </div>

                        <div>
                            Tabung:
                            <strong style="color:#024E7F;">
                                ${escapeHtml(kode)}
                            </strong>
                        </div>

                        <div>
                            Outlet:
                            <strong style="color:#B45309;">
                                ${escapeHtml(outlet)}
                            </strong>
                        </div>

                    </div>
                `,

                        showCancelButton: true,

                        confirmButtonText: '<i class="bi bi-check-lg"></i> Ya, Simpan',

                        cancelButtonText: '<i class="bi bi-x-lg"></i> Batal',

                        confirmButtonColor: '#F59E0B',

                        cancelButtonColor: '#64748B',

                        reverseButtons: true,

                        focusCancel: true

                    }).then(function(result) {

                        if (!result.isConfirmed) {
                            return;
                        }


                        /* =================================================
                           DISABLE BUTTON
                        ================================================= */

                        if (btnSimpan) {

                            btnSimpan.disabled = true;

                            btnSimpan.innerHTML = `
                        <span
                            class="spinner-border spinner-border-sm me-1"
                            role="status"
                            aria-hidden="true">
                        </span>
                        Menyimpan...
                    `;

                        }


                        /* =================================================
                           SUBMIT FORM
                        ================================================= */

                        form.submit();

                    });

                });

            }


            /* =========================================================
               SWEETALERT HAPUS CATATAN
            ========================================================= */

            document.querySelectorAll('.form-hapus-catatan')
                .forEach(function(form) {

                    form.addEventListener('submit', function(e) {

                        e.preventDefault();

                        const currentForm = this;

                        Swal.fire({

                            icon: 'warning',

                            title: 'Hapus Catatan?',

                            html: `
                        <div style="
                            font-size:13px;
                            color:#64748B;
                            line-height:1.6;
                        ">
                            Catatan khusus ini akan dihapus
                            dan <strong>tidak dapat dikembalikan</strong>.
                        </div>
                    `,

                            showCancelButton: true,

                            confirmButtonText: '<i class="bi bi-trash3"></i> Ya, Hapus',

                            cancelButtonText: '<i class="bi bi-x-lg"></i> Batal',

                            confirmButtonColor: '#DC2626',

                            cancelButtonColor: '#64748B',

                            reverseButtons: true,

                            focusCancel: true

                        }).then(function(result) {

                            if (!result.isConfirmed) {
                                return;
                            }

                            currentForm.submit();

                        });

                    });

                });


            /* =========================================================
               ESCAPE HTML
               Supaya isi catatan aman dimasukkan ke SweetAlert
            ========================================================= */

            function escapeHtml(text) {

                const div = document.createElement('div');

                div.textContent = text;

                return div.innerHTML;

            }

        });
    </script>


    <script>
        document.addEventListener('DOMContentLoaded', function() {

            /*
            |--------------------------------------------------------------------------
            | CLEAR SEARCH
            |--------------------------------------------------------------------------
            */
            const clearSearch =
                document.getElementById('clearSearch');

            const searchInput =
                document.getElementById('cari_tabung');


            if (clearSearch && searchInput) {

                clearSearch.addEventListener('click', function() {

                    searchInput.value = '';

                    const form =
                        document.getElementById('formSearchTabung');

                    if (form) {
                        form.submit();
                    }

                });

            }

        });
    </script>

    @if (session('success'))
        <script>
            document.addEventListener('DOMContentLoaded', function() {

                Swal.fire({
                    icon: 'success',
                    title: 'Berhasil!',
                    text: @json(session('success')),
                    confirmButtonText: 'OK',
                    confirmButtonColor: '#024E7F',
                    timer: 2500,
                    timerProgressBar: true
                });

            });
        </script>
    @endif

    @if (session('error'))
        <script>
            document.addEventListener('DOMContentLoaded', function() {

                Swal.fire({
                    icon: 'error',
                    title: 'Gagal!',
                    text: @json(session('error')),
                    confirmButtonText: 'OK',
                    confirmButtonColor: '#DC2626'
                });

            });
        </script>
    @endif
@endsection
