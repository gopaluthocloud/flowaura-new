<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sales & Leads Dashboard</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.0/dist/chart.umd.js"></script>
    <style>
        :root {
            --primary-color: #0066FF;
            --success-color: #10B981;
            --warning-color: #F59E0B;
            --danger-color: #EF4444;
            --info-color: #3B82F6;
            --sidebar-bg: #FFFFFF;
            --sidebar-hover: #F3F4F6;
            --sidebar-active: #EEF2FF;
            --border-color: #E5E7EB;
        }

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Inter', -apple-system, BlinkMacSystemFont, 'Segoe UI', sans-serif;
            background: #F9FAFB;
            color: #1F2937;
        }


        /* Main Content */
        .main-content {
            margin-left: 240px;
            min-height: 100vh;
        }

        /* Header */
        .top-header {
            background: white;
            border-bottom: 1px solid var(--border-color);
            padding: 16px 32px;
            position: sticky;
            top: 0;
            z-index: 999;
        }



        .header-content {
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 24px;
        }

        .header-title {
            display: flex;
            flex-direction: column;
        }

        .header-title h1 {
            font-size: 20px;
            font-weight: 600;
            margin: 0;
        }

        .header-title small {
            color: #6B7280;
            font-size: 13px;
        }

        .header-search {
            flex: 1;
            max-width: 400px;
        }

        .header-search input {
            width: 100%;
            padding: 8px 16px 8px 40px;
            border: 1px solid var(--border-color);
            border-radius: 8px;
            font-size: 14px;
        }

        .search-wrapper {
            position: relative;
        }

        .search-wrapper i {
            position: absolute;
            left: 12px;
            top: 50%;
            transform: translateY(-50%);
            color: #9CA3AF;
        }

        .header-actions {
            display: flex;
            align-items: center;
            gap: 12px;
        }

        .btn-add {
            background: var(--primary-color);
            color: white;
            border: none;
            padding: 8px 16px;
            border-radius: 8px;
            display: flex;
            align-items: center;
            gap: 6px;
            font-size: 14px;
            font-weight: 500;
        }

        .btn-icon {
            width: 36px;
            height: 36px;
            border-radius: 8px;
            border: 1px solid var(--border-color);
            background: white;
            display: flex;
            align-items: center;
            justify-content: center;
            position: relative;
        }

        .notification-badge {
            position: absolute;
            top: -4px;
            right: -4px;
            background: var(--danger-color);
            color: white;
            font-size: 10px;
            padding: 2px 5px;
            border-radius: 10px;
        }

        .soft-alert {
            position: fixed;
            top: 20px;
            right: 20px;
            min-width: 260px;
            padding: 12px 16px;
            border-radius: 6px;
            color: #fff;
            font-size: 14px;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.15);
            opacity: 0;
            transform: translateY(-10px);
            transition: all 0.3s ease;
            z-index: 9999;
        }

        .soft-alert.show {
            opacity: 1;
            transform: translateY(0);
        }

        .soft-alert.success {
            background-color: #16a34a;
        }

        .soft-alert.error {
            background-color: #dc2626;
        }

        .soft-alert.info {
            background-color: #2563eb;
        }

        .soft-alert.warning {
            background-color: #d97706;
        }

        .user-avatar {
            width: 36px;
            height: 36px;
            border-radius: 50%;
            background: #E0E7FF;
            display: flex;
            align-items: center;
            justify-content: center;
            color: var(--primary-color);
            font-weight: 600;
        }

        .contact-sidebar {
            position: fixed;
            right: -905px;
            top: 0;
            width: 905px;
            height: 100vh;
            background: white;
            box-shadow: -4px 0 16px rgba(0, 0, 0, 0.1);
            z-index: 3000;
            transition: right 0.3s ease;
            overflow-y: auto;
        }

        .contact-sidebar.show {
            right: 0;
        }

        .sidebar-overlay {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(0, 0, 0, 0.3);
            z-index: 2999;
            display: none;
        }

        .sidebar-overlay.show {
            display: block;
        }

        .sidebar-header {
            padding: 20px;
            border-bottom: 1px solid var(--border-color);
            display: flex;
            justify-content: space-between;
            align-items: center;
            background: #F9FAFB;
        }

        .sidebar-header h3 {
            font-size: 18px;
            font-weight: 600;
            margin: 0;
        }

        #itemsSidebar {
            right: -1200px;
            /* z-index: 1051; */
            width: 1200px;
        }

        #itemsSidebar.active {
            right: 0;
        }

        .sidebar-close {
            background: none;
            border: none;
            font-size: 24px;
            cursor: pointer;
            color: #6B7280;
            padding: 0;
            line-height: 1;
        }

        .sidebar-close:hover {
            color: #1F2937;
        }

        .contact-info {
            padding: 20px;
            border-bottom: 1px solid var(--border-color);
        }

        .sidebar-tabs {
            display: flex;
            border-bottom: 1px solid var(--border-color);
            background: #F9FAFB;
        }

        .sidebar-tab {
            flex: 1;
            padding: 12px;
            border: none;
            background: none;
            font-size: 13px;
            font-weight: 500;
            color: #6B7280;
            cursor: pointer;
            border-bottom: 2px solid transparent;
            transition: all 0.2s;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .sidebar-tab:hover {
            color: var(--primary-color);
        }

        .sidebar-tab.active {
            color: var(--primary-color);
            border-bottom-color: var(--primary-color);
        }

        .sidebar-content {
            padding: 20px;
            height: calc(100vh - 350px);
            overflow-y: auto;
        }

        .tab-content {
            display: none;
        }

        .tab-content.active {
            display: block;
        }

        /* Make sure the contact sidebar is visible on mobile */
        @media (max-width: 768px) {
            .contact-sidebar {
                width: 100%;
                right: -100%;
            }
        }

        /* Filter Bar */
        .filter-bar {
            background: white;
            padding: 16px 32px;
            border-bottom: 1px solid var(--border-color);
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 16px;
            flex-wrap: wrap;
        }

        .filter-chips {
            display: flex;
            gap: 8px;
            flex-wrap: wrap;
            flex: 1;
        }


        .filter-actions {
            display: flex;
            gap: 8px;
        }

        .btn-filter {
            padding: 6px 16px;
            border-radius: 6px;
            border: 1px solid var(--border-color);
            background: white;
            font-size: 13px;
            cursor: pointer;
        }

        .btn-filter.primary {
            background: var(--primary-color);
            color: white;
            border-color: var(--primary-color);
        }

        /* manage target sidebar */
        /* Team Target Sidebar specific styles */
        .contact-sidebar {
            transition: right 0.3s ease;
        }

        .contact-sidebar.show {
            right: 0;
        }

        .sidebar-overlay {
            transition: opacity 0.3s ease;
        }

        .sidebar-overlay.show {
            display: block;
            opacity: 1;
        }

        /* Sidebars container */
        .sidebars-container {
            position: fixed;
            top: 0;
            right: 0;
            z-index: 1000;
        }

        /* Ensure proper layering when both are open */
        #sidebar.open {
            right: 0;
            z-index: 1000;
        }

        #itemsSidebar.active {
            right: 0;
            margin-left: -100px;
            /* Adjust based on your design */
            z-index: 1001;
        }

        /* Adjust for responsive design */
        @media (max-width: 768px) {
            .right-sidebar {
                width: 100% !important;
                right: -100%;
            }

            .right-sidebar.open {
                right: 0;
                width: 100% !important;
            }

            #itemsSidebar.active {
                width: 100% !important;
                right: 0;
                margin-left: 0;
            }
        }

        .global-loader {
            position: fixed;
            inset: 0;
            background: rgba(255, 255, 255, 0.85);
            backdrop-filter: blur(2px);
            display: none;
            align-items: center;
            justify-content: center;
            z-index: 9999;
        }

        .global-loader.active {
            display: flex;
        }

        /* Loader Box */
        .loader-content {
            text-align: center;
            background: white;
            padding: 30px 40px;
            border-radius: 12px;
            box-shadow: 0 8px 32px rgba(0, 0, 0, 0.15);
            border: 1px solid var(--border-color);
            min-width: 200px;

            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
        }

        /* Spinner */
        .loader-spinner {
            width: 50px;
            height: 50px;
            border: 4px solid #f3f3f3;
            border-top: 4px solid var(--primary-color);
            border-radius: 50%;
            animation: spin 1s linear infinite;
            margin-bottom: 15px;
        }

        /* Text */
        .loader-text {
            font-size: 14px;
            color: #4b5563;
            font-weight: 500;
        }

        /* Button Loading State */
        .btn-loading {
            position: relative;
            color: transparent !important;
        }

        .btn-loading::after {
            content: '';
            position: absolute;
            left: 50%;
            top: 50%;
            transform: translate(-50%, -50%);
            width: 18px;
            height: 18px;
            border: 2px solid rgba(255, 255, 255, 0.3);
            border-top: 2px solid white;
            border-radius: 50%;
            animation: spin 0.8s linear infinite;
        }

        /* Clean Spin Animation */
        @keyframes spin {
            from {
                transform: rotate(0deg);
            }

            to {
                transform: rotate(360deg);
            }
        }

        /* Small Loader */
        .small-loader {
            display: inline-block;
            width: 16px;
            height: 16px;
            border: 2px solid rgba(255, 255, 255, 0.3);
            border-top: 2px solid white;
            border-radius: 50%;
            animation: spin 0.8s linear infinite;
            vertical-align: middle;
            margin-right: 8px;
        }

        /* Shimmer */
        .shimmer {
            background: linear-gradient(90deg, #f0f0f0 25%, #e0e0e0 50%, #f0f0f0 75%);
            background-size: 200% 100%;
            animation: shimmer 1.5s infinite;
        }

        @keyframes shimmer {
            0% {
                background-position: -200% 0;
            }

            100% {
                background-position: 200% 0;
            }
        }

        /* Form styles */
        .form-group {
            margin-bottom: 1rem;
        }

        .form-group label {
            display: block;
            margin-bottom: 0.5rem;
            font-weight: 500;
            color: #374151;
        }

        .form-control {
            width: 100%;
            padding: 0.5rem 0.75rem;
            font-size: 0.875rem;
            line-height: 1.5;
            color: #374151;
            background-color: #fff;
            border: 1px solid #d1d5db;
            border-radius: 0.375rem;
            transition: border-color 0.15s ease-in-out, box-shadow 0.15s ease-in-out;
        }

        .form-control:focus {
            outline: 0;
            border-color: #3b82f6;
            box-shadow: 0 0 0 3px rgba(59, 130, 246, 0.1);
        }

        /* Button styles */
        .btn-warning {
            background-color: #f59e0b;
            border-color: #f59e0b;
            /* color: white; */
        }

        .btn-warning:hover {
            background-color: #d97706;
            border-color: #d97706;
        }

        /* Content Area */
        .content-area {
            padding: 24px 32px;
        }

        /* Section */
        .section {
            background: white;
            border-radius: 12px;
            padding: 20px;
            margin-bottom: 20px;
            border: 1px solid var(--border-color);
        }

        .section-header {
            display: flex;
            align-items: center;
            justify-content: space-between;
            margin-bottom: 16px;
        }


        .section-title {
            font-size: 16px;
            font-weight: 600;
            margin: 0;
        }

        .section-actions {
            display: flex;
            gap: 8px;
        }

        .btn-sm {
            padding: 4px 12px;
            font-size: 13px;
            border-radius: 6px;
            border: 1px solid var(--border-color);
            background: white;
            cursor: pointer;
        }

        /* Task Table */
        .task-table {
            width: 100%;
            border-collapse: separate;
            border-spacing: 0 8px;
        }

        .task-table thead th {
            font-size: 12px;
            font-weight: 600;
            color: #6B7280;
            text-transform: uppercase;
            padding: 8px 12px;
            border-bottom: 1px solid var(--border-color);
        }

        .task-table tbody tr {
            background: #F9FAFB;
            border-radius: 8px;
            cursor: pointer;
            transition: all 0.2s;
        }

        .task-table tbody tr:hover {
            background: #EEF2FF;
            transform: scale(1.002);
        }

        .task-table tbody td {
            padding: 12px;
            font-size: 14px;
        }

        .task-table tbody tr td:first-child {
            border-radius: 8px 0 0 8px;
        }

        .task-table tbody tr td:last-child {
            border-radius: 0 8px 8px 0;
        }

        .user-info {
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .deals-table {
            display: none;
        }

        .deals-table.show {
            display: block;
        }


        .user-avatar-sm {
            width: 32px;
            height: 32px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 12px;
            font-weight: 600;
            color: white;
        }

        .user-details h6 {
            font-size: 14px;
            font-weight: 500;
            margin: 0;
        }

        .user-details small {
            font-size: 12px;
            color: #6B7280;
        }

        .badge {
            padding: 4px 10px;
            border-radius: 12px;
            font-size: 12px;
            font-weight: 500;
        }

        .badge.done {
            background: #D1FAE5;
            color: #065F46;
        }

        .badge.contacted {
            background: #DBEAFE;
            color: #1E40AF;
        }

        /* Stats Grid - Two Rows */
        .stats-grid-row-1 {
            display: grid;
            grid-template-columns: repeat(4, 1fr);
            gap: 16px;
            margin-top: 16px;
        }

        /* Table styling */
        #sidebar-table {
            font-size: 0.85rem;
        }

        #sidebar-table th {
            background-color: #f8f9fa;
            border-bottom: 2px solid #dee2e6;
            padding: 10px 8px;
            font-weight: 600;
            color: #495057;
        }

        #sidebar-table td {
            padding: 8px;
            vertical-align: middle;
            border-top: 1px solid #dee2e6;
        }

        #sidebar-table tr.even-row {
            background-color: #f8f9fa;
        }

        #sidebar-table tr.odd-row {
            background-color: #ffffff;
        }

        #sidebar-table tr:hover {
            background-color: #e9ecef;
        }

        #sidebar-table .badge {
            font-size: 0.75em;
            padding: 3px 8px;
            border-radius: 10px;
        }

        /* Make table scrollable */
        .sidebar-content {
            max-height: calc(100vh - 70px);
            overflow-y: auto;
        }

        .table-responsive {
            overflow-x: auto;
        }

        /* Loading spinner */
        #loading {
            text-align: center;
            padding: 40px;
            font-size: 1.2rem;
            color: #6c757d;
        }

        #loading::after {
            content: '';
            display: inline-block;
            width: 20px;
            height: 20px;
            margin-left: 10px;
            border: 2px solid #f3f3f3;
            border-top: 2px solid #3498db;
            border-radius: 50%;
            animation: spin 1s linear infinite;
        }

        @keyframes spin {
            0% {
                transform: rotate(0deg);
            }

            100% {
                transform: rotate(360deg);
            }
        }

        .stats-grid-row-2 {
            display: grid;
            grid-template-columns: repeat(6, 1fr);
            gap: 16px;
            margin-top: 16px;
        }

        .stat-card {
            background: white;
            border: 1px solid var(--border-color);
            border-radius: 10px;
            padding: 16px;
            display: flex;
            align-items: center;
            justify-content: space-between;
        }

        .stat-card-large {
            padding: 20px;
        }

        .stat-info h6 {
            font-size: 12px;
            color: #6B7280;
            margin: 0 0 6px 0;
            font-weight: 500;
        }

        .stat-info h3 {
            font-size: 24px;
            font-weight: 700;
            margin: 0 0 4px 0;
        }

        .stat-info h3.large {
            font-size: 28px;
        }

        .stat-info small {
            font-size: 11px;
            color: #6B7280;
        }

        .stat-icon {
            width: 44px;
            height: 44px;
            border-radius: 10px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 20px;
        }

        .stat-icon.large {
            width: 52px;
            height: 52px;
            font-size: 24px;
        }

        .stat-icon.blue {
            background: #DBEAFE;
            color: #1E40AF;
        }

        .stat-icon.green {
            background: #D1FAE5;
            color: #065F46;
        }

        .stat-icon.yellow {
            background: #FEF3C7;
            color: #92400E;
        }

        .stat-icon.orange {
            background: #FFEDD5;
            color: #C2410C;
        }

        .stat-icon.red {
            background: #FEE2E2;
            color: #991B1B;
        }

        .stat-icon.purple {
            background: #EDE9FE;
            color: #5B21B6;
        }

        /* Chart Styles */
        .chart-container {
            padding: 16px;
            background: #F9FAFB;
            border-radius: 12px;
        }

        .chart-title {
            font-size: 14px;
            font-weight: 600;
            margin: 0 0 4px 0;
        }

        .chart-subtitle {
            font-size: 12px;
            color: #6B7280;
            margin: 0 0 16px 0;
        }

        .chart-wrapper {
            position: relative;
            width: 180px;
            height: 180px;
            margin: 0 auto;
        }

        .chart-center-text {
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            text-align: center;
        }

        .chart-center-text h2 {
            font-size: 28px;
            font-weight: 700;
            margin: 0;
            color: var(--success-color);
        }

        .chart-center-text small {
            font-size: 11px;
            color: #6B7280;
        }

        .chart-legend {
            margin-top: 20px;
        }

        .legend-item {
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 8px 0;
            border-bottom: 1px solid var(--border-color);
        }

        .legend-item:last-child {
            border-bottom: none;
        }

        .legend-label {
            display: flex;
            align-items: center;
            gap: 8px;
            font-size: 13px;
        }

        .legend-dot {
            width: 10px;
            height: 10px;
            border-radius: 50%;
        }

        .legend-value {
            font-weight: 600;
            font-size: 13px;
        }

        /* Pipeline */
        .pipeline-container {
            display: flex;
            gap: 16px;
            overflow-x: auto;
            padding-bottom: 12px;
        }

        .pipeline-stage {
            min-width: 200px;
            background: #F9FAFB;
            border-radius: 12px;
            padding: 16px;
        }

        .stage-header {
            display: flex;
            align-items: center;
            justify-content: space-between;
            margin-bottom: 8px;
        }

        .stage-title {
            font-size: 14px;
            font-weight: 600;
        }

        .stage-count {
            background: var(--primary-color);
            color: white;
            font-size: 11px;
            padding: 2px 8px;
            border-radius: 12px;
        }

        .stage-value {
            font-size: 18px;
            font-weight: 700;
            margin-bottom: 12px;
        }

        .pipeline-card {
            background: white;
            border-radius: 8px;
            padding: 12px;
            margin-bottom: 8px;
            border: 1px solid var(--border-color);
        }

        .pipeline-card h6 {
            font-size: 13px;
            font-weight: 600;
            margin: 0 0 8px 0;
        }

        .pipeline-card-row {
            display: flex;
            justify-content: space-between;
            font-size: 12px;
            color: #6B7280;
            margin-bottom: 4px;
        }

        .pipeline-card-value {
            font-weight: 500;
            color: #1F2937;
        }

        /* Activity Timeline */
        .activity-timeline {
            max-height: 400px;
            overflow-y: auto;
        }

        .activity-item {
            display: flex;
            gap: 12px;
            padding: 12px 0;
            border-bottom: 1px solid var(--border-color);
        }

        .activity-item:last-child {
            border-bottom: none;
        }

        .activity-icon {
            width: 36px;
            height: 36px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            flex-shrink: 0;
        }

        .activity-content {
            flex: 1;
        }

        .activity-content p {
            font-size: 13px;
            margin: 0 0 4px 0;
        }

        .activity-content small {
            font-size: 12px;
            color: #6B7280;
        }

        .activity-time {
            font-size: 12px;
            color: #9CA3AF;
        }

        /* Status Colors */
        .status-new {
            background: #DBEAFE;
            color: #1E40AF;
        }

        .status-contacted {
            background: #D1FAE5;
            color: #065F46;
        }

        .status-qualified {
            background: #FEF3C7;
            color: #92400E;
        }

        .status-proposal {
            background: #E0E7FF;
            color: #3730A3;
        }

        .status-negotiation {
            background: #FFEDD5;
            color: #C2410C;
        }

        /* Targets Table */
        .targets-table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 16px;
        }

        .targets-table thead th {
            background: #F9FAFB;
            font-size: 11px;
            font-weight: 600;
            color: #6B7280;
            text-transform: uppercase;
            padding: 10px 12px;
            text-align: left;
            border-bottom: 2px solid var(--border-color);
            white-space: nowrap;
        }

        .targets-table thead th[colspan] {
            text-align: center;
            border-left: 1px solid var(--border-color);
            border-right: 1px solid var(--border-color);
        }

        .targets-table thead th[rowspan] {
            vertical-align: middle;
        }

        .data-table {
            width: 100%;
            border-collapse: collapse;
            font-size: 14px;
        }

        .data-table thead th {
            background: linear-gradient(135deg, #F8FAFC, #F1F5F9);
            font-size: 11px;
            font-weight: 600;
            color: #475569;
            text-transform: uppercase;
            letter-spacing: 0.05em;
            padding: 12px 14px;
            font-size: 12px;
        }

        .right-sidebar {
            position: fixed;
            top: 0;
            right: -600px;
            width: 600px;
            height: 100%;
            background: white;
            box-shadow: -2px 0 10px rgba(0, 0, 0, 0.1);
            transition: right 0.3s ease;
            z-index: 1000;
            overflow-y: auto;
        }

        .right-sidebar.open {
            right: 0;
            width: 65% !important
        }

        .sidebar.open {
            right: 0;
            width: 65% !important
        }

        .sidebar-header {
            padding: 20px;
            border-bottom: 1px solid #eee;
            display: flex;
            justify-content: space-between;
            align-items: center;
            background: #f8f9fa;
        }

        .sidebar-header h5 {
            margin: 0;
            color: #333;
        }

        .close-btn {
            background: none;
            border: none;
            font-size: 24px;
            cursor: pointer;
            color: #666;
        }

        .sidebar-content {
            padding: 20px;
        }

        .stat-card {
            cursor: pointer;
            transition: transform 0.2s;
        }

        .stat-card:hover {
            transform: translateY(-2px);
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }

        .data-table tbody td {
            padding: 14px 16px;
            font-size: 13px;
            font-weight: 500;
            color: #374151;
            border-bottom: 1px solid #F3F4F6;
            vertical-align: middle;
        }

        .data-table tbody tr {
            cursor: pointer;
            transition: all 0.15s ease;
        }

        .data-table tbody tr:hover {
            background: #EEF2FF;
            transform: scale(1.002);
        }

        .data-table tbody tr:active {
            background: #E0E7FF;
        }

        /* Responsive table wrapper */
        .table-responsive {
            overflow-x: auto;
            -webkit-overflow-scrolling: touch;
            margin: 0 -20px;
            padding: 0 20px;
        }

        .data-table tbody td:first-child {
            font-weight: 600;
            color: #6B7280;
        }

        .data-table tbody td:nth-child(2) {
            font-weight: 600;
            color: #1F2937;
        }

        /* Add to your existing CSS */
        .empty-state {
            text-align: center;
            padding: 40px;
            color: #6b7280;
            font-size: 14px;
        }

        .empty-state i {
            font-size: 48px;
            margin-bottom: 16px;
            color: #d1d5db;
        }

        .progress-bar-custom {
            background: #E5E7EB;
            height: 8px;
            border-radius: 4px;
            overflow: hidden;
            width: 100px;
        }

        .progress-fill {
            height: 100%;
            background: var(--success-color);
            border-radius: 4px;
            transition: width 0.3s ease;
        }

        /* Status badges */
        .badge.ahead {
            background: #D1FAE5;
            color: #054231ff;
        }

        .badge.on-track {
            background: #D1FAE5;
            color: #065F46;
        }

        .badge.at-risk {
            background: #FEF3C7;
            color: #92400E;
        }

        .badge.behind {
            background: #FEE2E2;
            color: #991B1B;
        }

        .badge.pending {
            background: #FEF3C7;
            color: #92400E;
        }

        .badge.completed {
            background: #D1FAE5;
            color: #065F46;
        }

        .badge.overdue {
            background: #FEE2E2;
            color: #991B1B;
        }

        /* Calculated fields preview */
        .calculated-preview {
            background: #F9FAFB;
            border: 1px solid var(--border-color);
            border-radius: 8px;
            padding: 16px;
            margin-top: 20px;
        }

        .calculated-preview h4 {
            font-size: 13px;
            font-weight: 600;
            color: #374151;
            margin: 0 0 12px 0;
        }

        .calc-grid {
            display: grid;
            grid-template-columns: repeat(2, 1fr);
            gap: 12px;
        }

        .calc-item {
            display: flex;
            justify-content: space-between;
            font-size: 12px;
            padding: 6px 0;
            border-bottom: 1px dashed #E5E7EB;
        }

        .calc-item:last-child {
            border-bottom: none;
        }

        .calc-label {
            color: #6B7280;
        }

        .calc-value {
            font-weight: 600;
            color: #1F2937;
        }

        /* Period Dropdown */
        .period-dropdown {
            position: relative;
            display: inline-block;
        }

        .period-dropdown-btn {
            padding: 4px 12px;
            font-size: 13px;
            border-radius: 6px;
            border: 1px solid var(--border-color);
            background: white;
            cursor: pointer;
            display: flex;
            align-items: center;
            gap: 6px;
        }

        .period-dropdown-content {
            display: none;
            position: absolute;
            right: 0;
            top: 100%;
            background: white;
            min-width: 140px;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.15);
            border-radius: 8px;
            z-index: 1000;
            border: 1px solid var(--border-color);
            margin-top: 4px;
        }

        .period-dropdown-content.show {
            display: block;
        }

        /* User Dropdown Styles */
        .user-dropdown {
            position: relative;
            display: inline-block;
        }

        .user-avatar.dropdown-toggle {
            cursor: pointer;
            transition: all 0.2s;
        }

        .user-avatar.dropdown-toggle:hover {
            background: var(--primary-color);
            color: white;
        }

        .dropdown-menu {
            position: absolute;
            top: 100%;
            right: 0;
            min-width: 180px;
            background: white;
            border: 1px solid var(--border-color);
            border-radius: 8px;
            box-shadow: 0 4px 16px rgba(0, 0, 0, 0.1);
            padding: 8px 0;
            margin-top: 8px;
            z-index: 1000;
            display: none;
        }

        .dropdown-menu.show {
            display: block;
        }

        .dropdown-item {
            display: flex;
            align-items: center;
            padding: 8px 16px;
            color: #1F2937;
            text-decoration: none;
            font-size: 13px;
            font-weight: 400;
            transition: all 0.2s;
            background: none;
            border: none;
            width: 100%;
            text-align: left;
        }

        .dropdown-item:hover {
            background: #F3F4F6;
            color: var(--primary-color);
        }

        .dropdown-item.text-danger {
            color: var(--danger-color) !important;
        }

        .dropdown-item.text-danger:hover {
            background: #FEE2E2;
        }

        .dropdown-divider {
            height: 1px;
            background: var(--border-color);
            margin: 4px 0;
            border: none;
        }

        /* Modal Styles */
        .modal-overlay {
            display: none;
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(0, 0, 0, 0.5);
            z-index: 2000;
            align-items: center;
            justify-content: center;
        }

        .modal-overlay.show {
            display: flex;
        }

        .modal-content {
            background: white;
            border-radius: 12px;
            width: 100%;
            max-width: 600px;
            max-height: 90vh;
            overflow-y: auto;
            box-shadow: 0 20px 40px rgba(0, 0, 0, 0.2);
        }

        .modal-header {
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 20px 24px;
            border-bottom: 1px solid var(--border-color);
        }

        .modal-header h3 {
            font-size: 18px;
            font-weight: 600;
            margin: 0;
        }

        .modal-close {
            background: none;
            border: none;
            font-size: 24px;
            cursor: pointer;
            color: #6B7280;
            padding: 0;
            line-height: 1;
        }

        .modal-close:hover {
            color: #1F2937;
        }

        .modal-body {
            padding: 24px;
        }

        .form-group {
            margin-bottom: 20px;
        }

        .form-group label {
            display: block;
            font-size: 13px;
            font-weight: 500;
            color: #374151;
            margin-bottom: 6px;
        }

        .form-group label span {
            color: #EF4444;
        }

        .form-control {
            width: 100%;
            padding: 10px 12px;
            font-size: 14px;
            border: 1px solid var(--border-color);
            border-radius: 8px;
            background: white;
            transition: border-color 0.2s;
        }

        .form-control:focus {
            outline: none;
            border-color: var(--primary-color);
            box-shadow: 0 0 0 3px rgba(0, 102, 255, 0.1);
        }

        .form-row {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 16px;
        }

        .modal-footer {
            display: flex;
            justify-content: flex-end;
            gap: 12px;
            padding: 16px 24px;
            border-top: 1px solid var(--border-color);
            background: #F9FAFB;
            border-radius: 0 0 12px 12px;
        }

        .btn-cancel {
            padding: 10px 20px;
            font-size: 14px;
            border-radius: 8px;
            border: 1px solid var(--border-color);
            background: white;
            cursor: pointer;
            font-weight: 500;
        }

        .btn-cancel:hover {
            background: #F3F4F6;
        }

        .btn-save {
            padding: 10px 20px;
            font-size: 14px;
            border-radius: 8px;
            border: none;
            background: var(--primary-color);
            color: white;
            cursor: pointer;
            font-weight: 500;
        }

        .btn-save:hover {
            background: #0052CC;
        }

        /* Pagination Styles */
        .pagination-container {
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 8px;
            margin-top: 20px;
            padding: 16px 0;
        }

        .pagination-btn {
            min-width: 36px;
            height: 36px;
            padding: 0 12px;
            border: 1px solid var(--border-color);
            background: white;
            border-radius: 8px;
            font-size: 13px;
            cursor: pointer;
            display: flex;
            align-items: center;
            justify-content: center;
            transition: all 0.2s;
        }

        .pagination-btn:hover {
            border-color: var(--primary-color);
            color: var(--primary-color);
        }

        .pagination-btn.active {
            background: var(--primary-color);
            color: white;
            border-color: var(--primary-color);
        }

        .pagination-btn:disabled {
            opacity: 0.5;
            cursor: not-allowed;
        }

        .pagination-input {
            width: 60px;
            height: 36px;
            text-align: center;
            border: 1px solid var(--border-color);
            border-radius: 8px;
            font-size: 13px;
        }

        .pagination-input:focus {
            outline: none;
            border-color: var(--primary-color);
        }

        /* Clickable Card */
        .stat-card.clickable {
            cursor: pointer;
            transition: all 0.2s;
        }

        .stat-card.clickable:hover {
            border-color: var(--primary-color);
            box-shadow: 0 4px 12px rgba(0, 102, 255, 0.1);
        }

        .selected-filter {
            display: block;
            font-size: 11px;
            color: var(--primary-color);
            margin-top: 4px;
            font-weight: 500;
        }

        /* Contact Sidebar */
        .contact-sidebar {
            position: fixed;
            right: -905px;
            top: 0;
            width: 905px;
            height: 100vh;
            background: white;
            box-shadow: -4px 0 16px rgba(0, 0, 0, 0.1);
            z-index: 3000;
            transition: right 0.3s ease;
            overflow-y: auto;
        }

        .contact-sidebar.show {
            right: 0;
        }

        .sidebar-overlay {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(0, 0, 0, 0.3);
            z-index: 2999;
            display: none;
        }

        .sidebar-overlay.show {
            display: block;
        }

        .sidebar-header {
            padding: 20px;
            border-bottom: 1px solid var(--border-color);
            display: flex;
            justify-content: space-between;
            align-items: center;
            background: #F9FAFB;
        }

        .sidebar-header h3 {
            font-size: 18px;
            font-weight: 600;
            margin: 0;
        }

        .sidebar-close {
            background: none;
            border: none;
            font-size: 24px;
            cursor: pointer;
            color: #6B7280;
            padding: 0;
            line-height: 1;
        }

        .sidebar-close:hover {
            color: #1F2937;
        }

        .contact-info {
            padding: 20px;
            border-bottom: 1px solid var(--border-color);
        }

        .contact-avatar-large {
            width: 60px;
            height: 60px;
            border-radius: 50%;
            background: linear-gradient(135deg, #667EEA, #764BA2);
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 24px;
            font-weight: 700;
            color: white;
            margin-bottom: 12px;
        }

        .contact-name {
            font-size: 20px;
            font-weight: 600;
            margin: 0 0 4px 0;
        }

        .contact-email {
            font-size: 13px;
            color: #6B7280;
            margin: 0 0 12px 0;
        }

        .contact-details-grid {
            display: grid;
            grid-template-columns: repeat(2, 1fr);
            gap: 12px;
            margin-top: 16px;
        }

        .contact-detail-item {
            display: flex;
            flex-direction: column;
        }

        .contact-detail-label {
            font-size: 11px;
            color: #6B7280;
            text-transform: uppercase;
            font-weight: 600;
            margin-bottom: 4px;
        }

        .contact-detail-value {
            font-size: 13px;
            color: #1F2937;
            font-weight: 500;
        }

        /* Right Sidebar Container */
        .right-sidebar {
            position: fixed;
            top: 0;
            right: -65%;
            width: 600px;
            height: 100vh;
            background: white;
            box-shadow: -2px 0 10px rgba(0, 0, 0, 0.1);
            transition: right 0.3s ease;
            z-index: 1000;
            overflow-y: auto;
        }

        .right-sidebar.open {
            right: 0;
            width: 65% !important;
        }

        /* Invoice Items Sidebar (child of right sidebar) */
        #itemsSidebar {
            position: fixed;
            top: 0;
            right: -600px;
            width: 600px;
            height: 100vh;
            background: white;
            box-shadow: -4px 0 16px rgba(0, 0, 0, 0.1);
            z-index: 1001;
            /* Higher than right-sidebar */
            transition: right 0.3s ease;
            overflow-y: auto;
        }

        #itemsSidebar.active {
            right: 0;
        }

        /* When itemsSidebar is active, adjust main sidebar to 35% width */
        /* .right-sidebar.open+#itemsSidebar.active {
            right: calc(35% + 20px);
        } */

        /* Or if you want it to open on top: */

        #itemsSidebar.active {
            right: 0;
            width: 65%;
            z-index: 1002;
        }


        .sidebar-tabs {
            display: flex;
            border-bottom: 1px solid var(--border-color);
            background: #F9FAFB;
        }

        .sidebar-tab {
            flex: 1;
            padding: 12px;
            border: none;
            background: none;
            font-size: 13px;
            font-weight: 500;
            color: #6B7280;
            cursor: pointer;
            border-bottom: 2px solid transparent;
            transition: all 0.2s;
        }

        .sidebar-tab:hover {
            color: var(--primary-color);
        }

        .sidebar-tab.active {
            color: var(--primary-color);
            border-bottom-color: var(--primary-color);
        }

        .sidebar-content {
            padding: 20px;
        }

        .tab-content {
            display: none;
        }

        .tab-content.active {
            display: block;
        }

        .timeline-item {
            display: flex;
            gap: 12px;
            margin-bottom: 20px;
            position: relative;
        }

        .timeline-item:not(:last-child)::before {
            content: '';
            position: absolute;
            left: 17px;
            top: 40px;
            width: 2px;
            height: calc(100% - 20px);
            background: #E5E7EB;
        }

        .timeline-icon {
            width: 36px;
            height: 36px;
            border-radius: 50%;
            background: #EEF2FF;
            color: var(--primary-color);
            display: flex;
            align-items: center;
            justify-content: center;
            flex-shrink: 0;
            border: 2px solid white;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
        }

        .timeline-content {
            flex: 1;
        }

        .timeline-header {
            display: flex;
            justify-content: space-between;
            align-items: start;
            margin-bottom: 6px;
        }

        .timeline-user {
            font-size: 13px;
            font-weight: 600;
            color: #1F2937;
        }

        .timeline-date {
            font-size: 11px;
            color: #9CA3AF;
        }

        .timeline-note {
            font-size: 13px;
            color: #4B5563;
            margin: 0;
            line-height: 1.5;
        }

        .timeline-due {
            font-size: 11px;
            color: #EF4444;
            font-weight: 500;
            margin-top: 4px;
        }

        .add-followup-form {
            background: #F9FAFB;
            padding: 16px;
            border-radius: 8px;
            margin-bottom: 20px;
        }

        .add-followup-form textarea {
            width: 100%;
            padding: 10px;
            border: 1px solid var(--border-color);
            border-radius: 6px;
            font-size: 13px;
            resize: vertical;
            min-height: 80px;
            margin-bottom: 10px;
        }

        .add-followup-form button {
            width: 100%;
            padding: 8px;
            background: var(--primary-color);
            color: white;
            border: none;
            border-radius: 6px;
            font-size: 13px;
            font-weight: 500;
            cursor: pointer;
        }

        .add-followup-form button:hover {
            background: #0052CC;
        }

        .filter-table-container {
            margin-top: 20px;
            display: none;
        }

        .filter-table-container.show {
            display: block;
        }

        .filter-table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 12px;
        }

        .filter-table thead th {
            background: #F9FAFB;
            font-size: 11px;
            font-weight: 600;
            color: #6B7280;
            text-transform: uppercase;
            padding: 12px;
            text-align: left;
            border-bottom: 2px solid var(--border-color);
        }

        .filter-table tbody td {
            padding: 12px;
            font-size: 13px;
            border-bottom: 1px solid var(--border-color);
        }

        .filter-table tbody tr:hover {
            background: #F9FAFB;
        }

        @media (max-width: 1200px) {

            .stats-grid-row-1,
            .stats-grid-row-2 {
                grid-template-columns: repeat(2, 1fr);
            }
        }

        @media (max-width: 768px) {
            .main-sidebar {
                transform: translateX(-100%);
            }

            .main-content {
                margin-left: 0;
            }

            .two-column {
                grid-template-columns: 1fr;
            }

            .status-grid {
                grid-template-columns: repeat(2, 1fr);
            }

            .stats-grid-row-1,
            .stats-grid-row-2 {
                grid-template-columns: 1fr;
            }

            .form-row {
                grid-template-columns: 1fr;
            }

            .modal-content {
                margin: 16px;
            }

            .contact-sidebar {
                width: 100%;
                right: -100%;
            }
        }
    </style>
</head>


<body>
    <!-- Sidebar -->
    <?php include "../sidebar.php"; ?>


    <div class="global-loader" id="globalLoader">
        <div class="loader-content">
            <div class="loader-spinner"></div>
            <div class="loader-text" id="loaderText">
                Loading Dashboard...
            </div>
        </div>
    </div>
    <!-- Main Content -->
    <div class="main-content">
        <!-- Header -->
        <?php include "../header.php"; ?>
        <br>

        <!-- Filter Bar -->
        <div class="container-fluid mb-3">
            <div class="row g-3 align-items-end">

                <!-- Date From -->
                <div class="col-md-3">
                    <label for="date_from" class="form-label">Date From</label>
                    <input type="date" id="date_from" class="form-control">
                </div>

                <!-- Date To -->
                <div class="col-md-3">
                    <label for="date_to" class="form-label">Date To</label>
                    <input type="date" id="date_to" class="form-control">
                </div>

                <!-- Sales Person Dropdown -->
                <div class="col-md-3">
                    <label for="sales_person" class="form-label">Sales Person</label>
                    <select id="sales_person" class="form-select">
                        <option value="all">All Sales Persons</option>
                        <!-- Options will be populated by JavaScript -->
                    </select>
                </div>

                <!-- Get Report Button -->
                <div class="col-md-3">
                    <button class="btn btn-primary w-100" id="getReportBtn">
                        Get Report
                    </button>
                </div>

            </div>
        </div>

        <!-- Content Area -->
        <div class="content-area">
            <!-- Follow-ups & Tasks -->
            <div class="section">
                <div class="section-header">
                    <h2 class="section-title">Follow-ups & Tasks</h2>
                    <div class="section-actions">
                        <!-- FILTER BUTTON (hidden initially) -->
                        <button class="btn-sm" id="tasksFilterBtn" onclick="toggleTasksFilter()" style="display:none;">
                            <i class="bi bi-search"></i>
                        </button>

                        <!-- SEE TASKS BUTTON -->
                        <button class="btn-sm" id="seeTasksBtn" onclick="toggleTasks()">
                            See Tasks
                        </button>
                    </div>
                </div>
                <!-- Tasks Filter Form -->
                <div class="col-md-12" id="tasksFilterForm" style="display: none; padding: 4px;">
                    <div class="row">
                        <div class="col-md-3">
                            <label>Department</label>
                            <select class="form-control" id="filterDepartment">
                                <option value="">All Departments</option>
                                <option value="Sales">Sales</option>
                                <option value="Billing">Billing</option>
                                <option value="Support">Support</option>
                                <option value="Private">Private</option>
                                <option value="Collection">Collection</option>
                                <option value="Delivery">Delivery</option>
                                <option value="Ticket">Ticket</option>
                                <option value="Feedback">Feedback</option>
                                <option value="Other">Other</option>
                                <option value="Call">Call</option>
                            </select>
                        </div>
                        <div class="col-md-3">
                            <label>Status</label>
                            <select class="form-control" id="filterStatus">
                                <option value="">All Status</option>
                                <option value="24">Pending</option>
                                <option value="23">Completed</option>
                            </select>
                        </div>
                        <div class="col-md-3">
                            <label>Ref Type</label>
                            <select class="form-control" id="filterRefType">
                                <option value="">All Types</option>
                                <option value="call">Call</option>
                                <option value="ticket">Ticket</option>
                                <option value="client">Client</option>
                                <option value="private">Private</option>
                                <option value="contact">Contact</option>
                                <option value="vendor">Vendor</option>
                                <option value="inventory">Inventory</option>
                                <option value="contract">Contract</option>
                                <option value="purchaseorder">Purchase Order</option>
                                <option value="invoice">Invoice</option>
                                <option value="lead">Lead</option>
                                <option value="account">Account</option>
                                <option value="deal">Deal</option>
                            </select>
                        </div>
                        <div class="col-md-3">
                            <label>Ref ID</label>
                            <input type="text" class="form-control" id="filterRefId" placeholder="Enter Ref ID">
                        </div>
                    </div>
                    <br>
                    <div class="row">
                        <div class="col-md-3 filter-actions-group">
                            <button class="btn-filter primary" onclick="applyTasksFilter()"><i class="bi bi-funnel"></i>
                                Apply</button>
                            <button class="btn-filter" onclick="clearTasksFilter()"><i class="bi bi-x-circle"></i>
                                Clear</button>
                        </div>
                    </div>
                </div>
                <div class="stats-grid-row-1" id="header_card">
                </div>
                <div id="tasksTableWrapper" style="display: none;">
                    <table class="task-table" style="margin-top: 20px;">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>id</th>
                                <th>Type</th>
                                <th>Status</th>
                                <th>Followup Time</th>
                                <th>Reference #</th>
                                <th>Last Message</th>
                                <th>Assigned to</th>
                                <th>Department</th>
                                <th>Refrence</th>
                                <th>Entry Time</th>
                                <th>Completed</th>
                            </tr>
                        </thead>
                        <tbody id="tasksTableBody">
                            <!-- Tasks will be populated here -->
                        </tbody>
                    </table>

                    <div class="pagination-container" id="tasksPagination">
                        <!-- Pagination will be populated here -->
                    </div>
                </div>
            </div>

            <div class="section">
                <div class="row g-3" id="statsGridRow0"></div>
            </div>

            <!-- Sales Target & Performance Overview -->
            <div class="section">
                <div class="section-header">
                    <h2 class="section-title">Sales Target & Performance Overview</h2>
                </div>
                <div class="row">
                    <div class="col-md-4">
                        <!-- Quarter Target Achievement -->
                        <div class="chart-container">
                            <div class="chart-wrapper">
                                <canvas id="quarterTargetChart"></canvas>
                                <div class="chart-center-text">
                                    <h2 id="achievementPercent">86.1%</h2>
                                    <small>ACHIEVED</small>
                                </div>
                            </div>
                            <div class="chart-legend">
                                <div class="legend-item">
                                    <div class="legend-label">
                                        <span class="legend-dot" style="background: #10B981;"></span>
                                        <span>Target Achieved</span>
                                    </div>
                                    <span class="legend-value" id="targetAchieved">₹ 11.5Lk</span>
                                </div>
                                <div class="legend-item">
                                    <div class="legend-label">
                                        <span class="legend-dot" style="background: #E5E7EB;"></span>
                                        <span>Remaining Target</span>
                                    </div>
                                    <span class="legend-value" id="remainingTarget">₹ 11.5Lk</span>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-8">
                        <div class="chart-container">
                            <div class="section-header">
                                <h2 class="section-title">Lead Source & Stage Distribution</h2>
                            </div>
                            <p class="chart-subtitle">Lead Source</p>
                            <div style="height: 180px; margin-bottom: 20px;">
                                <canvas id="leadSourceChart"></canvas>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Stats Grid - Row 2: 6 Smaller Cards -->
            <div class="stats-grid-row-2" id="statsGridRow2">
                <!-- Small stats will be populated here -->
            </div>

            <!-- Deals -->
            <div class="section">
                <div class="section-header">
                    <h2 class="section-title">Total Funnel Value</h2>
                </div>
                <div class="stats-grid-row-1" id="totalFunnelValue">
                    <!-- Pipeline stages will be populated here -->
                </div>
                <!-- Filter Tables -->
                <div class="filter-table-container" id="dealsLostTable">
                    <h4 style="font-size: 14px; font-weight: 600; margin-bottom: 12px;">Deals Lost Details</h4>
                    <table class="filter-table">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Deal ID</th>
                                <th>Contact Name</th>
                                <th>Deal Name</th>
                                <th>Deal Amount</th>
                                <th>Assigned to</th>
                                <th>Deal Stage</th>
                            </tr>
                        </thead>
                        <tbody id="dealsLostTableBody">
                            <!-- Will be populated dynamically -->
                        </tbody>
                    </table>
                </div>
                <div class="filter-table-container" id="dealsWonTable">
                    <h4 style="font-size: 14px; font-weight: 600; margin-bottom: 12px;">Deals Won Details</h4>
                    <table class="filter-table">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Deal ID</th>
                                <th>Contact Name</th>
                                <th>Deal Name</th>
                                <th>Deal Amount</th>
                                <th>Assigned to</th>
                                <th>Deal Stage</th>
                            </tr>
                        </thead>
                        <tbody id="dealsWonTableBody">
                            <!-- Will be populated dynamically -->
                        </tbody>
                    </table>
                </div>
            </div>

            <!-- Recent Activity -->
            <div class="section">
                <div class="section-header">
                    <h2 class="section-title">Recent Activity</h2>
                </div>
                <div class="activity-timeline" id="activityTimeline">
                    <!-- Activities will be populated here -->
                </div>
            </div>

            <!-- Manage Sales Targets -->
            <div class="section">
                <div class="section-header">
                    <h2 class="section-title">Manage Sales Targets</h2>
                    <div class="section-actions">
                        <button class="btn-sm" onclick="openEditModal()">
                            <i class="bi bi-pencil"></i> Add Target
                        </button>
                    </div>
                </div>
                <div class="table-responsive">
                    <table class="data-table targets-table" id="targetsTable">
                        <thead>
                            <tr>
                                <th rowspan="3">#</th>
                                <th rowspan="3">YEAR</th>
                                <th rowspan="3">QUARTER</th>
                                <th rowspan="3">TOTAL TARGET<br><small style="font-weight: 400; color: #6B7280;">(MRR +
                                        WHOLE)</small></th>
                                <th rowspan="3">TARGET<br>MRR</th>
                                <th colspan="6" style="text-align: center; background: #F3F4F6;">MONTH WISE</th>
                                <th rowspan="3">ACHIEVED<br>REVENUE</th>
                                <th rowspan="3">ACHIEVED<br>MRR</th>
                                <th rowspan="3">ACHIEVEMENT</th>
                                <th rowspan="3">STATUS</th>
                                <th rowspan="3">ACTION</th>
                            </tr>
                            <tr>
                                <th colspan="3" style="text-align: center; background: #F9FAFB;">WHOLE</th>
                                <th colspan="3" style="text-align: center; background: #F9FAFB;">MRR</th>
                            </tr>
                            <tr>
                                <th style="text-align: center;">Month 1</th>
                                <th style="text-align: center;">Month 2</th>
                                <th style="text-align: center;">Month 3</th>
                                <th style="text-align: center;">Month 1</th>
                                <th style="text-align: center;">Month 2</th>
                                <th style="text-align: center;">Month 3</th>
                            </tr>
                        </thead>
                        <tbody>
                            <!-- Table rows will be populated here -->
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <!-- Add Target -->
    <div class="modal-overlay" id="editTargetModal">
        <div class="modal-content">
            <div class="modal-header">
                <h3 id="editTargetModalTitle">Add Target</h3>
                <button class="modal-close" onclick="closeEditModal()">&times;</button>
            </div>

            <div class="modal-body">
                <form id="editTargetForm" onsubmit="saveTarget(event)">
                    <input type="hidden" id="targetId" name="id">

                    <div class="form-group">
                        <label>Year <span>*</span></label>
                        <select class="form-control" id="targetYear" name="year" required>
                            <option value="">Select Year</option>
                            <option value="2024">2024</option>
                            <option value="2025">2025</option>
                            <option value="2026">2026</option>
                            <option value="2027">2027</option>
                            <option value="2028">2028</option>
                            <option value="2029">2029</option>
                            <option value="2030">2030</option>
                            <option value="2031">2031</option>
                            <option value="2032">2032</option>
                            <option value="2033">2033</option>
                            <option value="2034">2034</option>
                            <option value="2035">2035</option>
                            <option value="2036">2036</option>
                        </select>
                    </div>

                    <div class="form-group">
                        <label>Quarter <span>*</span></label>
                        <select class="form-control" id="targetQuarter" name="quarter" required>
                            <option value="">Select Quarter</option>
                            <option value="Q1">Q1 (April-May-June)</option>
                            <option value="Q2">Q2 (July-August-September)</option>
                            <option value="Q3">Q3 (October-November-December)</option>
                            <option value="Q4">Q4 (January-February-March)</option>
                        </select>
                    </div>

                    <div class="form-group">
                        <label>Whole Total Target (MRR + WHOLE) ₹ <span>*</span></label>
                        <input type="number" class="form-control" id="wholeTotalTarget" name="wholeTotalTarget"
                            required>
                    </div>

                    <div class="modal-footer">
                        <button type="button" class="btn-cancel" onclick="closeEditModal()">Cancel</button>
                        <button type="submit" class="btn-save" id="editTargetSubmitBtn">
                            Save Target
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Sidebars Container -->
    <div class="sidebars-container">
        <!-- Main Cards Sidebar -->
        <div id="sidebar" class="right-sidebar">
            <div class="sidebar-header d-flex justify-content-between align-items-center">
                <h5 id="sidebar-title">Exclude Invoices</h5>
                <div class="d-flex align-items-center gap-2">
                    <button id="invoiceToggleBtn" class="btn btn-primary" onclick="toggleInvoice()">
                        Include Invoices
                    </button>
                    <button class="close-btn" id="sidebar-close">×</button>
                </div>
            </div>
            <div class="sidebar-content">
                <div class="table-responsive">
                    <table id="sidebar-table" class="table table-striped table-hover">
                        <thead id="sidebar-table-header"></thead>
                        <tbody id="sidebar-table-body"></tbody>
                    </table>
                </div>
                <div id="loading" style="display:none;">Loading...</div>
            </div>
        </div>

        <!-- Invoice Items Sidebar -->
        <div id="itemsSidebar" class="right-sidebar">
            <div class="sidebar-header d-flex justify-content-between align-items-center">
                <h5>Invoice Items</h5>
                <div class="d-flex align-items-center gap-2">
                    <button id="toggleInvoiceItemsBtn" class="btn btn-outline-primary" onclick="toggleInvoiceItems()">
                        Exclude Invoices
                    </button>
                    <button class="close-btn" onclick="closeItemsSidebar()">×</button>
                </div>
            </div>
            <div class="sidebar-content">
                <div id="invoiceItemsContainer"></div>
            </div>
        </div>
    </div>

    <!-- Contact Sidebar -->
    <div class="sidebar-overlay" id="sidebarOverlay" onclick="closeContactSidebar()"></div>
    <div class="contact-sidebar" id="contactSidebar">
        <div class="sidebar-header">
            <h3>Contact Details</h3>
            <button class="sidebar-close" onclick="closeContactSidebar()">&times;</button>
        </div>

        <div class="contact-info" id="contactInfoContent">
            <h2 id="contactFullName" style="font-size: 18px; font-weight: 600; margin-bottom: 20px;"></h2>

            <!-- Contact details in table format -->
            <div class="contact-details-table" style="width: 100%;">
                <!-- Row 1 -->
                <div class="detail-row" style="display: flex; margin-bottom: 12px;">
                    <div style="flex: 1;">
                        <div style="font-size: 12px; color: #6b7280; margin-bottom: 4px;">Firstname</div>
                        <div style="font-size: 14px; font-weight: 500;" id="firstName"></div>
                    </div>
                    <div style="flex: 1;">
                        <div style="font-size: 12px; color: #6b7280; margin-bottom: 4px;">Lastname</div>
                        <div style="font-size: 14px; font-weight: 500;" id="lastName"></div>
                    </div>
                    <div style="flex: 1;">
                        <div style="font-size: 12px; color: #6b7280; margin-bottom: 4px;">Job Title</div>
                        <div style="font-size: 14px; font-weight: 500;" id="jobTitle"></div>
                    </div>
                    <div style="flex: 1;">
                        <div style="font-size: 12px; color: #6b7280; margin-bottom: 4px;">Mobile</div>
                        <div style="font-size: 14px; font-weight: 500;" id="mobile"></div>
                    </div>
                </div>

                <!-- Row 2 -->
                <div class="detail-row" style="display: flex; margin-bottom: 12px;">
                    <div style="flex: 1;">
                        <div style="font-size: 12px; color: #6b7280; margin-bottom: 4px;">Email</div>
                        <div style="font-size: 14px; font-weight: 500;" id="email"></div>
                    </div>
                    <div style="flex: 1;">
                        <div style="font-size: 12px; color: #6b7280; margin-bottom: 4px;">City</div>
                        <div style="font-size: 14px; font-weight: 500;" id="city"></div>
                    </div>
                    <div style="flex: 1;">
                        <div style="font-size: 12px; color: #6b7280; margin-bottom: 4px;">State</div>
                        <div style="font-size: 14px; font-weight: 500;" id="state"></div>
                    </div>
                    <div style="flex: 1;">
                        <div style="font-size: 12px; color: #6b7280; margin-bottom: 4px;">Country</div>
                        <div style="font-size: 14px; font-weight: 500;" id="country"></div>
                    </div>
                </div>

                <!-- Row 3 -->
                <div class="detail-row" style="display: flex;">
                    <div style="flex: 1;">
                        <div style="font-size: 12px; color: #6b7280; margin-bottom: 4px;">Owner</div>
                        <div style="font-size: 14px; font-weight: 500;" id="owner"></div>
                    </div>
                    <div style="flex: 1;">
                        <div style="font-size: 12px; color: #6b7280; margin-bottom: 4px;">Status</div>
                        <div style="font-size: 14px; font-weight: 500;" id="status"></div>
                    </div>
                    <div style="flex: 1;">
                        <div style="font-size: 12px; color: #6b7280; margin-bottom: 4px;">Source</div>
                        <div style="font-size: 14px; font-weight: 500;" id="source"></div>
                    </div>
                    <div style="flex: 1;">
                        <div style="font-size: 12px; color: #6b7280; margin-bottom: 4px;">Medium</div>
                        <div style="font-size: 14px; font-weight: 500;" id="medium"></div>
                    </div>
                </div>
            </div>
        </div>

        <div class="sidebar-tabs">
            <button class="sidebar-tab active" onclick="switchTab('activity')">
                <span style="margin-right: 8px;">🚡</span> Activity
            </button>
            <button class="sidebar-tab" onclick="switchTab('notes')">
                <span style="margin-right: 8px;">🚡</span> Notes
            </button>
            <button class="sidebar-tab" onclick="switchTab('calls')">
                <span style="margin-right: 8px;">🚡</span> Calls
            </button>
            <button class="sidebar-tab" onclick="switchTab('logs')">Logs</button>
        </div>

        <div class="sidebar-content">
            <!-- Activity Tab -->
            <div class="tab-content active" id="activity-tab">
                <div style="margin-bottom: 20px;">
                    <div style="font-size: 14px; font-weight: 600; margin-bottom: 8px;">Add Followup</div>
                    <div style="display: flex; align-items: center; gap: 8px; margin-bottom: 12px;">
                        <div style="font-size: 12px; color: #6b7280; min-width: 50px;">Due At</div>
                        <input type="text" id="dueAtDate"
                            style="flex: 1; padding: 6px 10px; border: 1px solid #d1d5db; border-radius: 4px; font-size: 13px; background: white;"
                            placeholder="Cal" readonly>
                        <input type="text" id="dueAtType"
                            style="flex: 1; padding: 6px 10px; border: 1px solid #d1d5db; border-radius: 4px; font-size: 13px; background: white;"
                            placeholder="Call" readonly>
                    </div>
                    <textarea id="followupMessage" placeholder="Type your follow-up note here..."
                        style="width: 100%; min-height: 80px; padding: 10px; border: 1px solid #d1d5db; border-radius: 4px; font-size: 13px; resize: vertical; margin-bottom: 12px;"></textarea>
                    <button onclick="addFollowup()"
                        style="background: #3b82f6; color: white; border: none; padding: 8px 16px; border-radius: 4px; font-size: 13px; font-weight: 500; cursor: pointer;">Add
                        Followup</button>
                </div>

                <div id="activityContent">
                    <!-- Activity items will be populated here -->
                </div>
            </div>

            <!-- Notes Tab -->
            <div class="tab-content" id="notes-tab">
                <div style="display: flex; gap: 8px; margin-bottom: 20px;">
                    <button onclick="addNote()"
                        style="background: #3b82f6; color: white; border: none; padding: 8px 16px; border-radius: 4px; font-size: 13px; font-weight: 500; cursor: pointer;">Add
                        Note</button>
                    <button onclick="closeNote()"
                        style="background: #f3f4f6; color: #374151; border: 1px solid #d1d5db; padding: 8px 16px; border-radius: 4px; font-size: 13px; font-weight: 500; cursor: pointer;">Close</button>
                </div>
                <div id="notesContent" style="text-align: center; padding: 40px;">
                    <!-- Notes will be populated here -->
                </div>
            </div>

            <!-- Calls Tab -->
            <div class="tab-content" id="calls-tab">
                <div style="text-align: right; margin-bottom: 20px;">
                    <button onclick="closeCalls()"
                        style="background: #f3f4f6; color: #374151; border: 1px solid #d1d5db; padding: 8px 16px; border-radius: 4px; font-size: 13px; font-weight: 500; cursor: pointer;">Close</button>
                </div>
                <div style="overflow-x: auto;">
                    <table style="width: 100%; border-collapse: collapse; font-size: 13px;">
                        <thead>
                            <tr style="background: #f9fafb;">
                                <th
                                    style="padding: 12px 16px; text-align: left; font-weight: 500; color: #6b7280; font-size: 12px;">
                                    Time</th>
                                <th
                                    style="padding: 12px 16px; text-align: left; font-weight: 500; color: #6b7280; font-size: 12px;">
                                    Type</th>
                                <th
                                    style="padding: 12px 16px; text-align: left; font-weight: 500; color: #6b7280; font-size: 12px;">
                                    Caller</th>
                                <th
                                    style="padding: 12px 16px; text-align: left; font-weight: 500; color: #6b7280; font-size: 12px;">
                                    Receiver</th>
                                <th
                                    style="padding: 12px 16px; text-align: left; font-weight: 500; color: #6b7280; font-size: 12px;">
                                    Status</th>
                                <th
                                    style="padding: 12px 16px; text-align: left; font-weight: 500; color: #6b7280; font-size: 12px;">
                                    Duration</th>
                            </tr>
                        </thead>
                        <tbody id="callsContent">
                            <!-- Calls will be populated here -->
                        </tbody>
                    </table>
                </div>
            </div>

            <!-- Logs Tab -->
            <div class="tab-content" id="logs-tab">
                <div style="overflow-x: auto;">
                    <table style="width: 100%; border-collapse: collapse; font-size: 13px;">
                        <thead>
                            <tr style="background: #f9fafb;">
                                <th
                                    style="padding: 12px 16px; text-align: left; font-weight: 500; color: #6b7280; font-size: 12px;">
                                    Log</th>
                                <th
                                    style="padding: 12px 16px; text-align: left; font-weight: 500; color: #6b7280; font-size: 12px;">
                                    By</th>
                                <th
                                    style="padding: 12px 16px; text-align: left; font-weight: 500; color: #6b7280; font-size: 12px;">
                                    Time</th>
                            </tr>
                        </thead>
                        <tbody id="logsContent">
                            <!-- Logs will be populated here -->
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <!-- Team Target Management Sidebar -->
    <div class="sidebar-overlay" id="teamTargetOverlay" onclick="closeTeamTargetSidebar()"></div>
    <div class="contact-sidebar" id="teamTargetSidebar" style="width: 900px;">
        <div class="sidebar-header">
            <h3>Team Targets Management</h3>
            <button class="sidebar-close" onclick="closeTeamTargetSidebar()">&times;</button>
        </div>

        <div class="sidebar-content" style="padding: 20px;">
            <!-- Header section showing Quarter info -->
            <div
                style="margin-bottom: 30px; padding: 20px; background: #f8f9fa; border-radius: 8px; border-left: 4px solid var(--primary-color);">
                <h4 style="margin: 0; color: var(--primary-color);" id="teamTargetHeader">Team Targets of Quarter - Q2
                    of 2036</h4>
            </div>

            <!-- Set Team Target Button -->
            <div style="text-align: right; margin-bottom: 20px;">
                <button class="btn-add" onclick="showTeamTargetForm()">
                    <i class="bi bi-plus-lg"></i>
                    Set Team Target
                </button>
            </div>

            <!-- Team Targets Table -->
            <div id="teamTargetsTableContainer">
                <div style="overflow-x: auto;">
                    <table class="data-table" style="width: 100%;">
                        <thead>
                            <tr style="background: linear-gradient(135deg, #F8FAFC, #F1F5F9);">
                                <th style="padding: 12px; text-align: left; font-size: 12px;">#</th>
                                <th style="padding: 12px; text-align: left; font-size: 12px;">Name</th>
                                <th style="padding: 12px; text-align: left; font-size: 12px;">Year</th>
                                <th style="padding: 12px; text-align: left; font-size: 12px;">Quarter</th>
                                <th style="padding: 12px; text-align: left; font-size: 12px;">Overall Target</th>
                                <th style="padding: 12px; text-align: left; font-size: 12px;">1st Month</th>
                                <th style="padding: 12px; text-align: left; font-size: 12px;">2nd Month</th>
                                <th style="padding: 12px; text-align: left; font-size: 12px;">3rd Month</th>
                            </tr>
                        </thead>
                        <tbody id="teamTargetsTableBody">
                            <!-- Team targets will be populated here -->
                        </tbody>
                    </table>
                </div>
            </div>

            <!-- Team Target Form (Hidden by default) -->
            <div id="teamTargetFormContainer"
                style="display: none; margin-top: 30px; padding: 20px; background: #f8f9fa; border-radius: 8px;">
                <h5 style="margin-bottom: 20px; color: var(--primary-color);">Add Team Target</h5>

                <form id="teamTargetForm">
                    <div class="row" style="margin-bottom: 20px;">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Team Member *</label>
                                <select class="form-control" id="teamMemberSelect" required
                                    style="width: 100%; padding: 10px; border: 1px solid var(--border-color); border-radius: 6px;">
                                    <option value="">Select Team Member</option>
                                    <!-- Options will be populated dynamically -->
                                </select>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Target Amount (₹) *</label>
                                <input type="number" class="form-control" id="targetAmount" required
                                    placeholder="Enter target amount"
                                    style="width: 100%; padding: 10px; border: 1px solid var(--border-color); border-radius: 6px;">
                            </div>
                        </div>
                    </div>

                    <div class="row" style="margin-bottom: 20px;">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Year *</label>
                                <select class="form-control" id="targetYearForm" required
                                    style="width: 100%; padding: 10px; border: 1px solid var(--border-color); border-radius: 6px;">
                                    <option value="">Select Year</option>
                                    <option value="2024">2024</option>
                                    <option value="2025">2025</option>
                                    <option value="2026">2026</option>
                                    <option value="2027">2027</option>
                                    <option value="2028">2028</option>
                                    <option value="2029">2029</option>
                                    <option value="2030">2030</option>
                                    <option value="2031">2031</option>
                                    <option value="2032">2032</option>
                                    <option value="2033">2033</option>
                                    <option value="2034">2034</option>
                                    <option value="2035">2035</option>
                                    <option value="2036">2036</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Quarter *</label>
                                <select class="form-control" id="targetQuarterForm" required
                                    style="width: 100%; padding: 10px; border: 1px solid var(--border-color); border-radius: 6px;">
                                    <option value="">Select Quarter</option>
                                    <option value="Q1">Q1 (April-May-June)</option>
                                    <option value="Q2">Q2 (July-August-September)</option>
                                    <option value="Q3">Q3 (October-November-December)</option>
                                    <option value="Q4">Q4 (January-February-March)</option>
                                </select>
                            </div>
                        </div>
                    </div>

                    <div style="display: flex; gap: 10px; justify-content: flex-end;">
                        <button type="button" class="btn-cancel" onclick="hideTeamTargetForm()"
                            style="padding: 10px 20px;">Cancel</button>
                        <button type="submit" class="btn-save" style="padding: 10px 20px;">Add Team Target</button>
                    </div>
                </form>
            </div>

            <!-- Loading state -->
            <div id="teamTargetLoading" style="display: none; text-align: center; padding: 40px;">
                <div
                    style="display: inline-block; width: 30px; height: 30px; border: 3px solid #f3f3f3; border-top: 3px solid #3498db; border-radius: 50%; animation: spin 1s linear infinite;">
                </div>
                <p style="margin-top: 10px; color: #6c757d;">Loading team targets...</p>
            </div>
        </div>
    </div>

    <script src="../api.js"></script>

    <script>
        // ============ GLOBAL VARIABLES ============
        let currentTaskFilters = {
            department: '',
            status: '',
            ref_type: '',
            ref_id: ''
        };
        let currentCategory = '';
        let mainFilters = {
            sales_person: '',
            date_from: '',
            date_to: ''
        };
        let staffList = [];
        let leadSourceChartInstance = null;
        let quarterTargetChartInstance = null;
        let currentContactId = null;
        let tasksLoaded = false;
        let currentTeamTarget = null;
        let currentFilters = {};
        let dashboardData = {};
        let currentPage = 1;
        const itemsPerPage = 10;
        let filteredTasks = [];
        let allTasks = [];
        let dealsLostReasons = [];
        let dealsWonTypes = [];
        let dealsLostData = [];
        let dealsWonData = [];
        let selectedDealsLostReason = '';
        let selectedDealsWonType = '';
        let invoiceItemsInclude = 1;
        let currentInvoiceUserId = null;
        let currentInvoiceId = null;
        let currentUserId = null;
        let currentUserName = null;
        let includeInvoice = 0; // default = Exclude invoices

        // ============ INITIALIZATION ============
        async function initDashboard() {
            showLoader('Initializing dashboard...');
            try {
                // Load staff first
                await loadStaffList();

                // Load dashboard data
                await loadDashboard();

                // Setup initial report
                const initialFormData = getFormData();
                await loadKPIReport(initialFormData);

                // Setup event listeners
                setupEventListeners();

            } catch (error) {
                console.error('Dashboard initialization error:', error);
                softAlert('Error initializing dashboard', 'error');
            } finally {
                hideLoader();
            }
        }

        // ============ STAFF LIST FUNCTIONS ============
        async function loadStaffList() {
            try {
                // console.log("Loading staff list...");

                const response = await callApi('staff', {}, 'GET');
                // console.log('Staff API response:', response);

                // Check different possible response structures
                if (response && Array.isArray(response)) {
                    staffList = response;
                } else if (response && response.available_staff && Array.isArray(response.available_staff)) {
                    staffList = response.available_staff;
                } else if (response && response.data && Array.isArray(response.data)) {
                    staffList = response.data;
                } else if (response && response.staffs && Array.isArray(response.staffs)) {
                    staffList = response.staffs;
                } else {
                    console.warn('Unexpected staff response structure:', response);
                    staffList = [];
                }

                // console.log(`Loaded ${staffList.length} staff members`);

                populateSalesPersonDropdown();
                populateTeamMemberDropdown();

            } catch (error) {
                console.error('Error loading staff list:', error);
                staffList = [];
                softAlert('Error loading staff list', 'error');
            }
        }

        function populateSalesPersonDropdown() {
            const dropdown = document.getElementById('sales_person');
            if (!dropdown) return;

            // Clear existing options except the first one
            while (dropdown.options.length > 1) {
                dropdown.remove(1);
            }

            // Add staff options
            staffList.forEach(staff => {
                const fullName = getStaffFullName(staff);
                const option = document.createElement('option');
                option.value = staff.id;
                option.textContent = fullName;
                dropdown.appendChild(option);
            });
        }

        function populateTeamMemberDropdown() {
            const dropdown = document.getElementById('teamMemberSelect');
            if (!dropdown) return;

            // Clear existing options except the first one
            dropdown.innerHTML = '<option value="">Select Team Member</option>';

            // Add staff options
            staffList.forEach(staff => {
                const fullName = getStaffFullName(staff);
                const option = document.createElement('option');
                option.value = staff.id;
                option.textContent = fullName;
                dropdown.appendChild(option);
            });
        }

        function getStaffFullName(staff) {
            const firstName = staff.firstname || '';
            const lastName = staff.lastname || '';
            const fullName = `${firstName} ${lastName}`.trim();

            if (!fullName) {
                return staff.username || `User ${staff.id}`;
            }

            return fullName;
        }

        // ============ DASHBOARD LOADING ============
        async function loadDashboard() {
            try {
                showLoader('Loading Dashboard...');
                const result = await loadOverdueFollowups();

                if (!result) return;

                const { data, header_card, contacts } = result;
                allDueCards = header_card?.followups?.due || [];
                allTasks = data?.followups || [];
                filteredTasks = allTasks;

                getSourceStatusData(contacts);
                headerCards(allDueCards);
                renderTasks(currentPage);

            } catch (error) {
                console.error('Error loading dashboard:', error);
                softAlert('Error loading dashboard', 'error');
            } finally {
                hideLoader();
            }
        }

        async function loadOverdueFollowups() {
            try {
                const [data, header_card, contacts] = await Promise.all([
                    callApi("followup").catch(err => {
                        console.error('Error loading followups:', err);
                        return { followups: [] };
                    }),
                    callApi("report_followups").catch(err => {
                        console.error('Error loading report followups:', err);
                        return { followups: { due: [] } };
                    }),
                    callApi("contact").catch(err => {
                        console.error('Error loading contacts:', err);
                        return { contacts: [] };
                    })
                ]);
                return { data, header_card, contacts };
            } catch (error) {
                console.error('Error in loadOverdueFollowups:', error);
                return {
                    data: { followups: [] },
                    header_card: { followups: { due: [] } },
                    contacts: { contacts: [] }
                };
            }
        }

        // ============ KPI REPORT ============
        async function loadKPIReport({ sales_person, date_from, date_to }) {
            try {
                setButtonLoading(document.getElementById('getReportBtn'), true);
                showLoader('Generating Report...');

                currentFilters = { sales_person, date_from, date_to };

                const [adminRes, dealRes] = await Promise.all([
                    callApi('adminreport', {
                        assigned_to: sales_person,
                        create_start: date_from,
                        create_end: date_to
                    }).catch(err => {
                        console.error('Error loading admin report:', err);
                        return { staff: [{}], activity: [] };
                    }),
                    callApi('deal', {
                        userid: sales_person,
                        create_start: date_from,
                        create_end: date_to
                    }).catch(err => {
                        console.error('Error loading deals:', err);
                        return { deals: [] };
                    })
                ]);

                // console.log(adminRes);

                const adminKpis = safeGet(adminRes, 'staff', {});
                const emp_target = adminRes.staff[0].emp_targets || {};

                // console.log(emp_target);
                const activity = safeGet(adminRes, 'staff.activity', []);

                renderKPICards(adminKpis || {});
                renderStatsRow2(adminKpis || {});
                totalFunnelValue(adminKpis || {});
                renderActivity(activity || []);

                const quarterWiseTargets = convertToQuarterWise(emp_target || []);
                // console.log(quarterWiseTargets);
                renderTargetsTable(quarterWiseTargets || []);
                performance_overview(emp_target || []);

            } catch (error) {
                console.error("KPI API error:", error);
                softAlert('Error loading report. Please try again.', 'error');

                renderKPICards({});
                renderStatsRow2({});
                totalFunnelValue({});
                renderActivity([]);
                renderTargetsTable([]);
                performance_overview([]);
            } finally {
                setButtonLoading(document.getElementById('getReportBtn'), false);
                hideLoader();
            }
        }

        // ============ FORM HANDLING ============
        function getFormData() {
            const rawFrom = document.getElementById("date_from").value;
            const rawTo = document.getElementById("date_to").value;

            return {
                date_from: convertToDMY(rawFrom),
                date_to: convertToDMY(rawTo),
                sales_person: document.getElementById("sales_person").value
            };
        }

        function convertToDMY(dateString) {
            if (!dateString) return '';
            const [year, month, day] = dateString.split("-");
            return `${year}-${month}-${day}`;
        }

        function convertToDMY(dateString) {
            if (!dateString) return '';
            const [year, month, day] = dateString.split("-");
            return `${year}-${month}-${day}`;
        }

        // ============ CHART FUNCTIONS ============
        function performance_overview(emp_target) {
            if (!emp_target || !Array.isArray(emp_target)) {
                document.getElementById('achievementPercent').innerText = '0%';
                document.getElementById('targetAchieved').innerText = formatINR(0);
                document.getElementById('remainingTarget').innerText = formatINR(0);
                salesTargetOverviewGraph({ achieved: 0, remaining: 0 });
                return;
            }

            let totalTarget = 0;
            let totalAchieved = 0;

            emp_target.forEach(item => {
                totalTarget += Number(safeGet(item, 'target_business', 0));
                totalAchieved += Number(safeGet(item, 'achived_buisness', 0));
            });

            const remainingTarget = Math.max(totalTarget - totalAchieved, 0);
            const achievedPercent = totalTarget > 0
                ? ((totalAchieved / totalTarget) * 100).toFixed(1)
                : 0;

            document.getElementById('achievementPercent').innerText = `${achievedPercent}%`;
            document.getElementById('targetAchieved').innerText = formatINR(totalAchieved);
            document.getElementById('remainingTarget').innerText = formatINR(remainingTarget);

            salesTargetOverviewGraph({
                achieved: totalAchieved,
                remaining: remainingTarget
            });
        }

        function salesTargetOverviewGraph(data) {
            // console.log(data);
            const ctx = document.getElementById('quarterTargetChart').getContext('2d');

            if (quarterTargetChartInstance) {
                quarterTargetChartInstance.destroy();
            }

            quarterTargetChartInstance = new Chart(ctx, {
                type: 'doughnut',
                data: {
                    labels: ['Achieved', 'Remaining'],
                    datasets: [{
                        data: [data.achieved, data.remaining],
                        backgroundColor: ['#10B981', '#E5E7EB'],
                        borderWidth: 0
                    }]
                },
                options: {
                    cutout: '75%',
                    plugins: {
                        legend: { display: false },
                        tooltip: { enabled: false }
                    }
                }
            });
        }

        async function getSourceStatusData(data) {
            try {
                const contacts = data.contacts || [];
                const sourceCount = contacts.reduce((acc, contact) => {
                    const source = contact.source || "Unknown";
                    acc[source] = (acc[source] || 0) + 1;
                    return acc;
                }, {});

                renderCharts(sourceCount);
            } catch (error) {
                console.error("Error fetching source/status data:", error);
            }
        }

        function renderCharts(sourceCount) {
            const canvas = document.getElementById('leadSourceChart');
            if (!canvas) return;

            const ctx = canvas.getContext('2d');

            if (leadSourceChartInstance) {
                leadSourceChartInstance.destroy();
                leadSourceChartInstance = null;
            }

            leadSourceChartInstance = new Chart(ctx, {
                type: 'doughnut',
                data: {
                    labels: Object.keys(sourceCount),
                    datasets: [{
                        data: Object.values(sourceCount),
                        backgroundColor: [
                            '#FF6384', '#36A2EB', '#FFCE56', '#4BC0C0',
                            '#9966FF', '#FF9F40', '#8AC926', '#1982C4'
                        ]
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: {
                        legend: {
                            position: 'bottom'
                        }
                    }
                }
            });
        }

        // ============ UTILITY FUNCTIONS ============
        function safeGet(obj, path, defaultValue = '') {
            if (!obj) return defaultValue;
            const keys = path.split('.');
            let result = obj;
            for (let key of keys) {
                if (result && typeof result === 'object' && key in result) {
                    result = result[key];
                } else {
                    return defaultValue;
                }
            }
            return result === null || result === undefined ? defaultValue : result;
        }

        function formatINR(value) {
            if (!value || isNaN(value)) return '₹ 0';
            if (value >= 100000) {
                return `₹ ${(value / 100000).toFixed(2)}Lk`;
            }
            if (value >= 1000) {
                return `₹ ${(value / 1000).toFixed(2)}K`;
            }
            return `₹ ${value.toFixed(2)}`;
        }

        function formatCurrency(value) {
            if (!value) return '₹ 0';
            if (typeof value === 'string' && value.includes('₹')) {
                return value;
            }
            const numValue = parseFloat(value);
            if (isNaN(numValue)) return '₹ 0';
            return `₹ ${numValue.toLocaleString('en-IN', {
                minimumFractionDigits: 2,
                maximumFractionDigits: 2
            })}`;
        }

        function escapeHtml(text) {
            const map = {
                '&': '&amp;',
                '<': '&lt;',
                '>': '&gt;',
                '"': '&quot;',
                "'": '&#039;'
            };
            return text.replace(/[&<>"']/g, function (m) { return map[m]; });
        }

        // ============ TASK MANAGEMENT ============
        function toggleTasks() {
            const tableWrapper = document.getElementById('tasksTableWrapper');
            const filterBtn = document.getElementById('tasksFilterBtn');
            const filterForm = document.getElementById('tasksFilterForm');
            const seeTasksBtn = document.getElementById('seeTasksBtn');
            const isHidden = tableWrapper.style.display === 'none';

            if (isHidden) {
                tableWrapper.style.display = 'block';
                filterBtn.style.display = 'inline-flex';
                filterForm.style.display = 'none';
                seeTasksBtn.innerText = 'Hide Tasks';
                if (!tasksLoaded) {
                    loadTasksData();
                    tasksLoaded = true;
                }
            } else {
                tableWrapper.style.display = 'none';
                filterBtn.style.display = 'none';
                filterForm.style.display = 'none';
                seeTasksBtn.innerText = 'See Tasks';
            }
        }

        function toggleTasksFilter() {
            const filterForm = document.getElementById('tasksFilterForm');
            filterForm.style.display = filterForm.style.display === 'none' ? 'block' : 'none';
        }

        async function loadTasksData() {
            await loadAllTasks();
        }

        async function loadAllTasks() {
            try {
                const data = await callApi("followup", { status: 24 });
                filteredTasks = data?.followups || [];
                allTasks = filteredTasks;
                currentPage = 1;
                renderTasks(currentPage);
            } catch (error) {
                console.error("Error loading tasks:", error);
            }
        }

        function renderTasks(page) {
            const tbody = document.getElementById('tasksTableBody');
            const start = (page - 1) * itemsPerPage;
            const end = start + itemsPerPage;
            const pageTasks = filteredTasks.slice(start, end);

            if (!pageTasks || pageTasks.length === 0) {
                tbody.innerHTML = `
                    <tr>
                        <td colspan="12" class="empty-state">
                            <i class="bi bi-inbox"></i>
                            <div>No tasks found</div>
                            <small>Try adjusting your filters</small>
                        </td>
                    </tr>
                `;
                return;
            }

            tbody.innerHTML = pageTasks.map((task, index) => `
                <tr onclick="openContactSidebar('${safeGet(task, 'ref_id', '')}')">
                    <td>${start + index + 1}</td>
                    <td>${safeGet(task, 'id', '')}</td>
                    <td><span class="badge ${safeGet(task, 'type_text') === 'Call' ? 'status-new' : safeGet(task, 'type_text') === 'Email' ? 'status-qualified' : 'status-contacted'}">${safeGet(task, 'type_text', '')}</span></td>
                    <td><span class="badge ${safeGet(task, 'status_text') === 'Completed' ? 'completed' : safeGet(task, 'status_text') === 'Overdue' ? 'overdue' : 'pending'}">${safeGet(task, 'status_text', '')}</span></td>
                    <td>${safeGet(task, 'followuptime', '')}</td>
                    <td>${safeGet(task, 'clientname', '')}</td>
                    <td>${safeGet(task, 'message', '')}</td>
                    <td>${safeGet(task, 'followup_admin_name', '')}</td>
                    <td>${safeGet(task, 'department', '')}</td>
                    <td>${safeGet(task, 'ref_type', '')}</td>
                    <td>${safeGet(task, 'entrytime', '')}</td>
                    <td>${safeGet(task, 'completedtime', '')}</td>
                </tr>
            `).join('');

            renderPagination();
        }

        function renderPagination() {
            const pagination = document.getElementById('tasksPagination');
            const totalPages = Math.ceil(filteredTasks.length / itemsPerPage);

            if (totalPages <= 1) {
                pagination.innerHTML = '';
                return;
            }

            let paginationHTML = `
                <button class="pagination-btn" onclick="changePage(${currentPage - 1})" ${currentPage === 1 ? 'disabled' : ''}>
                    <i class="bi bi-chevron-left"></i>
                </button>
            `;

            for (let i = 1; i <= totalPages; i++) {
                if (i === 1 || i === totalPages || (i >= currentPage - 1 && i <= currentPage + 1)) {
                    paginationHTML += `<button class="pagination-btn ${currentPage === i ? 'active' : ''}" onclick="changePage(${i})">${i}</button>`;
                } else if (i === currentPage - 2 || i === currentPage + 2) {
                    paginationHTML += `<span class="pagination-btn" style="cursor: default;">...</span>`;
                }
            }

            paginationHTML += `
                <button class="pagination-btn" onclick="changePage(${currentPage + 1})" ${currentPage === totalPages ? 'disabled' : ''}>
                    <i class="bi bi-chevron-right"></i>
                </button>
            `;

            pagination.innerHTML = paginationHTML;
        }

        function changePage(page) {
            const totalPages = Math.ceil(filteredTasks.length / itemsPerPage);
            if (page >= 1 && page <= totalPages) {
                currentPage = page;
                renderTasks(currentPage);
            }
        }

        // ============ RENDER FUNCTIONS ============
        function renderKPICards(kpis) {
            // console.log(kpis[0]);

            const statsGridRow0 = document.getElementById('statsGridRow0');
            const firstStats = [
                {
                    title: 'Total Business',
                    value: safeGet(kpis[0], 'total_business', 0),
                    icon: 'bi-file-earmark-text',
                    color: 'blue'
                },
                {
                    title: 'Active MRR',
                    value: safeGet(kpis[0], 'total_mrr', 0),
                    icon: 'bi-telephone',
                    color: 'green'
                },
                {
                    title: 'New Business',
                    value: safeGet(kpis[0], 'new_business', 0),
                    icon: 'bi-pie-chart',
                    color: 'green'
                },
                {
                    title: 'Funnel Size',
                    value: safeGet(kpis[0], 'total_deals', 0),
                    icon: 'bi-currency-rupee',
                    color: 'yellow'
                },
                {
                    title: 'Total Leads',
                    value: safeGet(kpis[0], 'total_leads', 0),
                    icon: 'bi-currency-rupee',
                    color: 'yellow'
                },
                {
                    title: 'Converted Leads',
                    value: safeGet(kpis[0], 'total_users', 0),
                    icon: 'bi-currency-rupee',
                    color: 'yellow'
                }
            ];

            statsGridRow0.innerHTML = firstStats.map(stat => `
                <div class="col-12 col-sm-6 col-md-4 col-lg-3 col-xxl-2">
                    <div class="stat-card clickable" data-title="${stat.title}" onclick="openSidebar('${stat.title}')">
                        <div class="stat-info">
                            <h6>${stat.title}</h6>
                            <h3 class="large">${stat.value || 0}</h3>
                        </div>
                        <div class="stat-icon large ${stat.color}">
                            <i class="${stat.icon}"></i>
                        </div>
                    </div>
                </div>
            `).join('');
        }

        function renderStatsRow2(kpis) {
            // console.log(kpis);
            const statsRow2 = document.getElementById('statsGridRow2');
            const smallStats = [
                { title: 'New', value: safeGet(kpis[0], 'new_contacts', 0), icon: 'bi-calendar-check', color: 'blue' },
                { title: 'Active', value: safeGet(kpis[0], 'active_contacts', 0), icon: 'bi-person-plus', color: 'blue' },
                { title: 'Retargeting', value: safeGet(kpis[0], 'closed_contacts', 0), icon: 'bi-check-circle', color: 'green' },
                { title: 'Urgent', value: safeGet(kpis[0], 'urgent_contacts', 0), icon: 'bi-clock-history', color: 'yellow' },
                { title: 'Not Contacted', value: safeGet(kpis[0], 'not_contacted_contacts', 0), icon: 'bi-file-earmark-arrow-up', color: 'orange' },
                { title: 'Contacted', value: safeGet(kpis[0], 'contacted_contacts', 0), icon: 'bi-file-earmark-arrow-up', color: 'orange' }
            ];

            statsRow2.innerHTML = smallStats.map(stat => `
                <div class="stat-card clickable" data-title="${stat.title}" onclick="openSidebar('${stat.title}')">
                    <div class="stat-info">
                        <h6>${stat.title}</h6>
                        <h3>${stat.value || 0}</h3>
                    </div>
                    <div class="stat-icon ${stat.color}">
                        <i class="${stat.icon}"></i>
                    </div>
                </div>
            `).join('');
        }

        function totalFunnelValue(kpie) {
            const totalFunnelValue = document.getElementById('totalFunnelValue');
            const largeStats = [
                {
                    title: 'Total No. of Prospects Added In Deals',
                    value: safeGet(kpie[0], 'total_deals', 0),
                    icon: 'bi-plus-circle',
                    color: 'blue',
                    clickable: false
                },
                {
                    title: 'Total Funnel Expected Value',
                    value: safeGet(kpie[0], 'total_deal_amount', 0),
                    icon: 'bi-currency-rupee',
                    color: 'yellow',
                    clickable: false
                },
                {
                    title: 'Deals Lost',
                    value: safeGet(kpie[0], 'total_deal_won', 0),
                    icon: 'bi-x-circle',
                    color: 'red',
                    clickable: true,
                    onClick: "applyDealsFilter('lost')"
                },
                {
                    title: 'Deals Won',
                    value: safeGet(kpie[0], 'total_deal_lost', 0),
                    icon: 'bi-trophy',
                    color: 'green',
                    clickable: true,
                    onClick: "applyDealsFilter('won')"
                }
            ];

            totalFunnelValue.innerHTML = largeStats.map(stat => `
                <div class="stat-card stat-card-large ${stat.clickable ? 'clickable' : ''}"
                    ${stat.clickable ? `onclick="${stat.onClick}"` : ''}>
                    <div class="stat-info">
                        <h6>${stat.title}</h6>
                        <h3 class="large">${stat.value || 0}</h3>
                        ${stat.title === 'Deals Lost' && selectedDealsLostReason ? `<span class="selected-filter">Filter: ${selectedDealsLostReason}</span>` : ''}
                        ${stat.title === 'Deals Won' && selectedDealsWonType ? `<span class="selected-filter">Type: ${selectedDealsWonType}</span>` : ''}
                    </div>
                    <div class="stat-icon large ${stat.color}">
                        <i class="${stat.icon}"></i>
                    </div>
                </div>
            `).join('');
        }

        function headerCards(kpie) {
            const headerCards = document.getElementById('header_card');
            const largeStats = [
                {
                    title: 'Overdue Followups',
                    value: safeGet(kpie, 'overdue', 0),
                    icon: 'bi-exclamation-triangle',
                    color: 'red',
                    category: 'overdue'
                },
                {
                    title: 'Today Due Followups',
                    value: safeGet(kpie, 'today', 0),
                    icon: 'bi-calendar-check',
                    color: 'blue',
                    category: 'today'
                },
                {
                    title: 'This Week Due Followup',
                    value: safeGet(kpie, 'week', 0),
                    icon: 'bi-calendar-week',
                    color: 'green',
                    category: 'week'
                },
                {
                    title: 'Next 30 Days Due',
                    value: safeGet(kpie, 'month', 0),
                    icon: 'bi-calendar-range',
                    color: 'yellow',
                    category: 'next30'
                }
            ];

            headerCards.innerHTML = largeStats.map(stat => `
                <div class="stat-card stat-card-large" style="flex-direction:column; align-items:flex-start;">
                    <div style="width:100%; display:flex; justify-content:space-between; align-items:center;">
                        <div class="stat-info">
                            <h6>${stat.title}</h6>
                            <h3 class="large">${stat.value || 0}</h3>
                        </div>
                        <div class="stat-icon large ${stat.color}">
                            <i class="bi ${stat.icon}"></i>
                        </div>
                    </div>
                    <hr style="width:100%; margin:10px 0;">
                    <a href="javascript:void(0)" onclick="filterTasksByCategory('${stat.category}')"
                       class="text-primary"
                       style="font-size:13px; text-decoration:underline; cursor:pointer;">
                       <i class="bi bi-list-ul"></i> View List
                    </a>
                </div>
            `).join('');
        }

        // ============ SIDEBAR FUNCTIONS ============
        async function openSidebar(cardTitle) {
            const config = cardConfig[cardTitle];
            if (!config) {
                console.error('No configuration found for:', cardTitle);
                return;
            }

            document.getElementById('sidebar-title').textContent = cardTitle;
            document.getElementById('loading').style.display = 'block';
            document.getElementById('sidebar-table').style.display = 'none';

            document.getElementById('sidebar').classList.add('open');
            closeItemsSidebar();

            const queryParams = {
                assigned_to: currentFilters.sales_person,
                create_start: currentFilters.date_from,
                create_end: currentFilters.date_to,
                ...config.queryParams
            };

            try {
                const response = await callApi(config.endpoint, queryParams, 'GET');
                const headersHtml = config.headers.map(header => `<th>${header}</th>`).join('');
                document.getElementById('sidebar-table-header').innerHTML = `<tr>${headersHtml}</tr>`;

                const tableBody = document.getElementById('sidebar-table-body');
                tableBody.innerHTML = '';

                let dataArray = [];
                if (response) {
                    if (response.contacts && Array.isArray(response.contacts)) {
                        dataArray = response.contacts;
                    } else if (response.users && Array.isArray(response.users)) {
                        dataArray = response.users;
                    } else if (response.data && Array.isArray(response.data)) {
                        dataArray = response.data;
                    } else if (response.deals && Array.isArray(response.deals)) {
                        dataArray = response.deals;
                    } else if (Array.isArray(response)) {
                        dataArray = response;
                    }
                }

                if (dataArray.length > 0) {
                    dataArray.forEach((item, index) => {
                        const row = document.createElement('tr');
                        const serialCell = document.createElement('td');
                        serialCell.textContent = index + 1;
                        row.appendChild(serialCell);

                        config.headers.slice(1).forEach(header => {
                            const cell = document.createElement('td');
                            let value = extractValue(item, header, config.endpoint);

                            if (header === 'Status' && item.status_color) {
                                cell.innerHTML = `<span class="badge" style="background-color: ${item.status_color}; color: #fff;">${value || ''}</span>`;
                            } else if (header === 'Source' && item.source_color) {
                                cell.innerHTML = `<span class="badge" style="background-color: ${item.source_color}; color: #fff;">${value || ''}</span>`;
                            } else if (header === 'Name') {
                                const contactId = item.id || '';
                                if (contactId) {
                                    cell.innerHTML = `<a href="/sale_contacts?action=viewcontact&id=${contactId}" target="_blank">${value}</a>`;
                                } else {
                                    cell.textContent = value;
                                }
                            } else if (header === 'Total Business' && config.endpoint === 'business_users') {
                                const userId = item.userid || '';
                                if (userId) {
                                    const displayValue = formatCurrency(value);
                                    cell.innerHTML = `
                                        <a href="javascript:void(0)" 
                                        onclick="showUserInvoices('${userId}', '${escapeHtml(item.fullname || '')} ${escapeHtml(item.last_name || '')}')"
                                        style="color: var(--primary-color); text-decoration: none; cursor: pointer;"
                                        onmouseover="this.style.textDecoration='underline'"
                                        onmouseout="this.style.textDecoration='none'">
                                            ${displayValue}
                                        </a>
                                    `;
                                } else {
                                    cell.textContent = value;
                                }
                            } else {
                                cell.textContent = value;
                            }

                            cell.setAttribute('data-field', header);
                            cell.setAttribute('data-value', value);
                            row.appendChild(cell);
                        });

                        if (index % 2 === 0) {
                            row.classList.add('even-row');
                        } else {
                            row.classList.add('odd-row');
                        }

                        tableBody.appendChild(row);
                    });

                    const countRow = document.createElement('tr');
                    const countCell = document.createElement('td');
                    countCell.colSpan = config.headers.length;
                    countCell.className = 'text-center text-muted small';
                    countCell.innerHTML = `<i class="bi bi-info-circle"></i> Showing ${dataArray.length} records`;
                    countRow.appendChild(countCell);
                    tableBody.appendChild(countRow);
                } else {
                    const noDataRow = document.createElement('tr');
                    const noDataCell = document.createElement('td');
                    noDataCell.colSpan = config.headers.length;
                    noDataCell.className = 'text-center text-muted py-5';
                    noDataCell.innerHTML = `
                        <i class="bi bi-inbox display-4 d-block mb-2"></i>
                        <div>No data found for the selected criteria</div>
                        <small class="text-muted">Try adjusting your filters or date range</small>
                    `;
                    noDataRow.appendChild(noDataCell);
                    tableBody.appendChild(noDataRow);
                }

                document.getElementById('loading').style.display = 'none';
                document.getElementById('sidebar-table').style.display = 'table';
                document.getElementById('sidebar').classList.add('open');
                closeItemsSidebar();

            } catch (error) {
                console.error('Error fetching data:', error);
                document.getElementById('loading').style.display = 'none';
                const errorRow = `<tr><td colspan="${config.headers.length}" class="text-center text-danger py-4">
                    <i class="bi bi-exclamation-triangle"></i> Error loading data: ${error.message || 'Unknown error'}
                </td></tr>`;
                document.getElementById('sidebar-table-body').innerHTML = errorRow;
            }
        }

        // Card configuration
        const cardConfig = {
            'Total Business': {
                endpoint: 'business_users',
                queryParams: { item_type: 'include', data_type: 'total' },
                headers: ['#', 'User ID', 'Customer Name', 'Total Business', 'Total MRR']
            },
            'Active MRR': {
                endpoint: 'business_users',
                queryParams: { item_type: 'include', data_type: 'total' },
                headers: ['#', 'User ID', 'Customer Name', 'Total Business', 'Total MRR']
            },
            'New Business': {
                endpoint: 'business_users',
                queryParams: { item_type: 'include', data_type: 'new' },
                headers: ['#', 'User ID', 'Customer Name', 'Total Business', 'Total MRR']
            },
            'Funnel Size': {
                endpoint: 'deal',
                headers: ['#', 'Deal ID', 'Contact Name', 'Deal Name', 'Deal Amount', 'Assigned to', 'Deal Stage']
            },
            'Total Leads': {
                endpoint: 'contact',
                headers: ['#', 'Name', 'Company', 'Location', 'Created At', 'Assigned to', 'Status', 'Source', 'Userid', 'Partner', 'MRR', 'Active MRR', 'Total Business', 'Cloud (A)', 'Cloud (D)', 'Customer From', 'Account Manager', 'Business Type', 'Employee Size', 'Monthly Spend', 'Title', 'Usecase', 'SMS Verified', 'AC Verified', 'Followup Time', 'Followup Message']
            },
            'Converted Leads': {
                endpoint: 'contact',
                queryParams: { type: 'customer' },
                headers: ['#', 'Name', 'Company', 'Location', 'Created At', 'Assigned to', 'Status', 'Source', 'Userid', 'Partner', 'MRR', 'Active MRR', 'Total Business', 'Cloud (A)', 'Cloud (D)', 'Customer From', 'Account Manager', 'Business Type', 'Employee Size', 'Monthly Spend', 'Title', 'Usecase', 'SMS Verified', 'AC Verified', 'Followup Time', 'Followup Message']
            },
            'New': {
                endpoint: 'contact',
                queryParams: { contact_status_id: 5 },
                headers: ['#', 'Name', 'Company', 'Location', 'Created At', 'Assigned to', 'Status', 'Source', 'Userid', 'Partner', 'MRR', 'Active MRR', 'Total Business', 'Cloud (A)', 'Cloud (D)', 'Customer From', 'Account Manager', 'Business Type', 'Employee Size', 'Monthly Spend', 'Title', 'Usecase', 'SMS Verified', 'AC Verified', 'Followup Time', 'Followup Message']
            },
            'Active': {
                endpoint: 'contact',
                queryParams: { contact_status_id: 6 },
                headers: ['#', 'Name', 'Company', 'Location', 'Created At', 'Assigned to', 'Status', 'Source', 'Userid', 'Partner', 'MRR', 'Active MRR', 'Total Business', 'Cloud (A)', 'Cloud (D)', 'Customer From', 'Account Manager', 'Business Type', 'Employee Size', 'Monthly Spend', 'Title', 'Usecase', 'SMS Verified', 'AC Verified', 'Followup Time', 'Followup Message']
            },
            'Retargeting': {
                endpoint: 'contact',
                queryParams: { contact_status_id: 7 },
                headers: ['#', 'Name', 'Company', 'Location', 'Created At', 'Assigned to', 'Status', 'Source', 'Userid', 'Partner', 'MRR', 'Active MRR', 'Total Business', 'Cloud (A)', 'Cloud (D)', 'Customer From', 'Account Manager', 'Business Type', 'Employee Size', 'Monthly Spend', 'Title', 'Usecase', 'SMS Verified', 'AC Verified', 'Followup Time', 'Followup Message']
            },
            'Urgent': {
                endpoint: 'contact',
                queryParams: { contact_status_id: 8 },
                headers: ['#', 'Name', 'Company', 'Location', 'Created At', 'Assigned to', 'Status', 'Source', 'Userid', 'Partner', 'MRR', 'Active MRR', 'Total Business', 'Cloud (A)', 'Cloud (D)', 'Customer From', 'Account Manager', 'Business Type', 'Employee Size', 'Monthly Spend', 'Title', 'Usecase', 'SMS Verified', 'AC Verified', 'Followup Time', 'Followup Message']
            },
            'Not Contacted': {
                endpoint: 'contact',
                queryParams: { contact_status_id: 58 },
                headers: ['#', 'Name', 'Company', 'Location', 'Created At', 'Assigned to', 'Status', 'Source', 'Userid', 'Partner', 'MRR', 'Active MRR', 'Total Business', 'Cloud (A)', 'Cloud (D)', 'Customer From', 'Account Manager', 'Business Type', 'Employee Size', 'Monthly Spend', 'Title', 'Usecase', 'SMS Verified', 'AC Verified', 'Followup Time', 'Followup Message']
            },
            'Contacted': {
                endpoint: 'contact',
                queryParams: { contact_status_id: 58 },
                headers: ['#', 'Name', 'Company', 'Location', 'Created At', 'Assigned to', 'Status', 'Source', 'Userid', 'Partner', 'MRR', 'Active MRR', 'Total Business', 'Cloud (A)', 'Cloud (D)', 'Customer From', 'Account Manager', 'Business Type', 'Employee Size', 'Monthly Spend', 'Title', 'Usecase', 'SMS Verified', 'AC Verified', 'Followup Time', 'Followup Message']
            }
        };

        const fieldMappings = {
            contact: {
                '#': 'id',
                'Name': function (item) {
                    const firstName = item.first_name || '';
                    const lastName = item.last_name || '';
                    const fullName = item.fullname || '';
                    if (firstName || lastName) {
                        return `${firstName} ${lastName}`.trim();
                    }
                    return fullName;
                },
                'Company': function (item) {
                    return item.client_company || '';
                },
                'Location': function (item) {
                    const city = item.city || '';
                    const state = item.state || '';
                    const country = item.country || '';
                    const parts = [city, state, country].filter(part => part && part.trim());
                    return parts.join(', ') || item.address || '';
                },
                'Created At': function (item) {
                    return item.created_at || '';
                },
                'Assigned to': function (item) {
                    return item.assigned_to_name || item.assigned_to || '';
                },
                'Status': function (item) {
                    return item.status || '';
                },
                'Source': function (item) {
                    return item.source || '';
                },
                'Userid': function (item) {
                    return item.client_id || item.userid || '';
                },
                'Partner': function (item) {
                    return item.partnerid || '';
                },
                'MRR': function (item) {
                    return item.cloud_total_mrr || '0';
                },
                'Active MRR': function (item) {
                    return item.cloud_total_mrr_active || item.cloud_total_mrr || '0';
                },
                'Total Business': function (item) {
                    return item.total_amountin || '0';
                },
                'Cloud (A)': function (item) {
                    return item.cloud_active_count || '0';
                },
                'Cloud (D)': function (item) {
                    return item.cloud_deleted_count || '0';
                },
                'Customer From': function (item) {
                    return item.client_created_at || '';
                },
                'Account Manager': function (item) {
                    return item.accountmanager || '';
                },
                'Business Type': function (item) {
                    return item.supportneed_businesstype || '';
                },
                'Employee Size': function (item) {
                    return item.supportneed_employeesize || '';
                },
                'Monthly Spend': function (item) {
                    return item.supportneed_monthlyspend || '';
                },
                'Title': function (item) {
                    return item.supportneed_title || item.job_title || '';
                },
                'Usecase': function (item) {
                    return item.supportneed_usecase || '';
                },
                'SMS Verified': function (item) {
                    return item.sms_verified || '';
                },
                'AC Verified': function (item) {
                    return item.verify || '';
                },
                'Followup Time': function (item) {
                    return item.followuptime || '';
                },
                'Followup Message': function (item) {
                    return item.followupmessage || '';
                },
                'Deal ID': function (item) {
                    return item.id || '';
                },
                'Contact Name': function (item) {
                    const firstName = item.contact_first_name || '';
                    const lastName = item.contact_last_name || '';
                    const fullName = item.fullname || '';
                    if (firstName || lastName) {
                        return `${firstName} ${lastName}`.trim();
                    }
                    return fullName;
                },
                'Deal Name': function (item) {
                    return item.name || '';
                },
                'Deal Amount': function (item) {
                    return item.amount || '';
                },
                'Assigned to': function (item) {
                    return item.assignedto_name || '';
                },
                'Deal Stage': function (item) {
                    return item.deal_stage || '';
                }
            },
            business_users: {
                '#': 'id',
                'User ID': function (item) {
                    return item.userid || item.client_id || item.id || '';
                },
                'Customer Name': function (item) {
                    const firstName = item.first_name || '';
                    const lastName = item.last_name || '';
                    const fullName = item.fullname || item.customer_name || '';
                    if (firstName || lastName) {
                        return `${firstName} ${lastName}`.trim();
                    }
                    return fullName;
                },
                'Total Business': function (item) {
                    return item.total_business || '0';
                },
                'Total MRR': function (item) {
                    return item.total_mrr || '0';
                }
            },
            deal: {
                '#': 'id',
                'Deal ID': function (item) {
                    return item.id || '';
                },
                'Contact Name': function (item) {
                    const firstName = item.contact_first_name || '';
                    const lastName = item.contact_last_name || '';
                    if (firstName || lastName) {
                        return `${firstName} ${lastName}`.trim();
                    }
                    if (item.contact && item.contact.first_name) {
                        return `${item.contact.first_name || ''} ${item.contact.last_name || ''}`.trim();
                    }
                    return item.contact_name || '';
                },
                'Deal Name': function (item) {
                    return item.name || '';
                },
                'Deal Amount': function (item) {
                    return item.amount || '0';
                },
                'Assigned to': function (item) {
                    return item.assignedto_name || item.assigned_to || '';
                },
                'Deal Stage': function (item) {
                    return item.deal_stage || '';
                }
            }
        };

        function extractValue(item, header, endpointType) {
            if (header === '#') {
                return '';
            }

            const mapping = fieldMappings[endpointType];
            if (!mapping) return '';

            const fieldMapper = mapping[header];
            if (!fieldMapper) return '';

            let value;
            if (typeof fieldMapper === 'function') {
                value = fieldMapper(item);
            } else {
                value = item[fieldMapper];
            }

            if (value === null || value === undefined) {
                return '';
            }

            return formatValue(value, header);
        }

        function formatValue(value, header) {
            if (value === null || value === undefined || value === '' || value === 'undefined') {
                return '';
            }

            const stringValue = String(value).trim();
            if (stringValue === '') {
                return '';
            }

            if (header.includes('Verified') || header === 'AC Verified') {
                if (stringValue === '1' || stringValue.toLowerCase() === 'true' || stringValue.toLowerCase() === 'yes') {
                    return 'Yes';
                } else if (stringValue === '0' || stringValue.toLowerCase() === 'false' || stringValue.toLowerCase() === 'no') {
                    return 'No';
                }
            }

            if (header.includes('Business') || header.includes('Amount') || header.includes('MRR') || header.includes('Spend')) {
                const numValue = parseFloat(stringValue.replace(/[^\d.-]/g, ''));
                if (!isNaN(numValue)) {
                    if (header === 'Total Business' || header === 'Amount') {
                        return numValue.toLocaleString('en-IN', {
                            style: 'currency',
                            currency: 'INR',
                            minimumFractionDigits: 2,
                            maximumFractionDigits: 2
                        });
                    } else {
                        return numValue.toLocaleString('en-US', {
                            minimumFractionDigits: 2,
                            maximumFractionDigits: 2
                        });
                    }
                }
            }

            if (header.includes('Cloud (A)') || header.includes('Cloud (D)') || header.includes('Count')) {
                const numValue = parseInt(stringValue);
                if (!isNaN(numValue)) {
                    return numValue.toLocaleString();
                }
            }

            if (header.includes('Created') || header.includes('Time') || header.includes('From')) {
                const cleanDateStr = stringValue.replace(/ Days? Ago/, '').trim();
                if (cleanDateStr.match(/^\d+$/)) {
                    return stringValue;
                } else if (stringValue.match(/\d{4}-\d{2}-\d{2}/)) {
                    try {
                        const date = new Date(stringValue.replace(' ', 'T'));
                        if (!isNaN(date.getTime())) {
                            return date.toLocaleDateString('en-US', {
                                year: 'numeric',
                                month: 'short',
                                day: 'numeric'
                            });
                        }
                    } catch (e) {
                        // If parsing fails, return original
                    }
                }
            }

            return stringValue;
        }

        // ============ INVOICE FUNCTIONS ============
        async function showUserInvoices(userId, userName) {
            currentUserId = userId;
            currentUserName = userName;

            try {
                document.getElementById('sidebar-title').textContent =
                    includeInvoice === 1
                        ? `Include Invoices - ${userName}`
                        : `Exclude Invoices - ${userName}`;

                document.getElementById('loading').style.display = 'block';
                document.getElementById('sidebar-table').style.display = 'none';

                const queryParams = {
                    userid: userId,
                    create_start: currentFilters.date_from,
                    create_end: currentFilters.date_to,
                    include: includeInvoice,
                    groupby: 'invoice'
                };

                const response = await callApi('business_users_invoices', queryParams);
                const invoiceHeaders = ['#', 'Invoicenum', 'Date', 'Due Date', 'Paid Date', 'Amount', 'Notes', 'Status'];

                const headersHtml = invoiceHeaders.map(header => `<th>${header}</th>`).join('');
                document.getElementById('sidebar-table-header').innerHTML = `<tr>${headersHtml}</tr>`;

                const tableBody = document.getElementById('sidebar-table-body');
                tableBody.innerHTML = '';

                if (response && response.invoiceInfo && Array.isArray(response.invoiceInfo) && response.invoiceInfo.length > 0) {
                    response.invoiceInfo.sort((a, b) => {
                        const dateA = new Date(a.date || '1970-01-01');
                        const dateB = new Date(b.date || '1970-01-01');
                        return dateB - dateA;
                    });

                    response.invoiceInfo.forEach((invoice, index) => {
                        const row = document.createElement('tr');
                        const invoiceId = document.createElement('td');
                        invoiceId.textContent = invoice.id || '';
                        row.appendChild(invoiceId);

                        const invNumCell = document.createElement('td');
                        invNumCell.textContent = invoice.invoicenum || '';
                        row.appendChild(invNumCell);

                        const dateCell = document.createElement('td');
                        dateCell.textContent = invoice.date || '';
                        row.appendChild(dateCell);

                        const dueDateCell = document.createElement('td');
                        dueDateCell.textContent = invoice.duedate || '';
                        row.appendChild(dueDateCell);

                        const paidDateCell = document.createElement('td');
                        paidDateCell.textContent = invoice.datepaid || '';
                        row.appendChild(paidDateCell);

                        const amountCell = document.createElement('td');
                        const amount = parseFloat(invoice.total) || 0;
                        amountCell.innerHTML = `
                            <span 
                                class="invoice-amount"
                                data-userid="${invoice.userid}"
                                data-invoiceid="${invoice.id}"
                                style="cursor:pointer;color:#2563EB;font-weight:600;"
                            >
                                Rs.${amount.toFixed(2)}
                            </span>
                        `;
                        row.appendChild(amountCell);

                        const notesCell = document.createElement('td');
                        notesCell.textContent = invoice.notes || '';
                        row.appendChild(notesCell);

                        const statusCell = document.createElement('td');
                        const status = invoice.status || 'Unknown';
                        let badgeClass = '';
                        if (status.toLowerCase() === 'paid') {
                            badgeClass = 'badge completed';
                        } else if (status.toLowerCase() === 'unpaid') {
                            badgeClass = 'badge overdue';
                        } else {
                            badgeClass = 'badge pending';
                        }
                        statusCell.innerHTML = `<span class="${badgeClass}">${status}</span>`;
                        row.appendChild(statusCell);

                        if (index % 2 === 0) {
                            row.classList.add('even-row');
                        } else {
                            row.classList.add('odd-row');
                        }

                        tableBody.appendChild(row);
                    });

                    const totalAmount = response.invoiceInfo.reduce((sum, invoice) => {
                        return sum + (parseFloat(invoice.total) || 0);
                    }, 0);

                    const summaryRow = document.createElement('tr');
                    const summaryCell = document.createElement('td');
                    summaryCell.colSpan = invoiceHeaders.length;
                    summaryCell.style.backgroundColor = '#F8F9FA';
                    summaryCell.style.fontWeight = '600';
                    summaryCell.style.padding = '12px';
                    summaryCell.style.textAlign = 'right';
                    summaryCell.innerHTML = `Total: <span style="color: var(--primary-color);">Rs. ${totalAmount.toFixed(2)}</span>`;
                    summaryRow.appendChild(summaryCell);
                    tableBody.appendChild(summaryRow);

                } else {
                    const noDataRow = document.createElement('tr');
                    const noDataCell = document.createElement('td');
                    noDataCell.colSpan = invoiceHeaders.length;
                    noDataCell.className = 'text-center text-muted py-5';
                    noDataCell.innerHTML = `
                        <i class="bi bi-receipt display-4 d-block mb-2"></i>
                        <div>No invoices found for this user</div>
                        <small class="text-muted">No invoice data available for the selected period</small>
                    `;
                    noDataRow.appendChild(noDataCell);
                    tableBody.appendChild(noDataRow);
                }

                document.getElementById('loading').style.display = 'none';
                document.getElementById('sidebar-table').style.display = 'table';
                document.getElementById('sidebar').classList.add('open');

            } catch (error) {
                console.error('Error fetching user invoices:', error);
                document.getElementById('loading').style.display = 'none';
                const invoiceHeaders = ['#', 'Invoicenum', 'Date', 'Due Date', 'Paid Date', 'Amount', 'Notes', 'Status'];
                const errorRow = `<tr><td colspan="${invoiceHeaders.length}" class="text-center text-danger py-4">
                    <i class="bi bi-exclamation-triangle"></i> Error loading invoices: ${error.message || 'Unknown error'}
                </td></tr>`;
                document.getElementById('sidebar-table-body').innerHTML = errorRow;
                document.getElementById('sidebar-table').style.display = 'table';
            }
        }

        // ============ SIDEBAR MANAGEMENT ============
        function closeSidebar() {
            document.getElementById('sidebar').classList.remove('open');
            closeItemsSidebar();
        }

        document.getElementById('sidebar-close').addEventListener('click', closeSidebar);

        document.addEventListener('click', function (event) {
            const sidebar = document.getElementById('sidebar');
            const itemsSidebar = document.getElementById('itemsSidebar');

            if (sidebar.classList.contains('open') &&
                !sidebar.contains(event.target) &&
                !event.target.closest('.stat-card') &&
                !itemsSidebar.contains(event.target)) {
                closeSidebar();
            }

            if (itemsSidebar.classList.contains('active') &&
                !itemsSidebar.contains(event.target) &&
                !event.target.closest('.invoice-amount')) {
                closeItemsSidebar();
            }
        });

        // ============ INVOICE ITEMS ============
        document.addEventListener('click', function (e) {
            const el = e.target.closest('.invoice-amount');
            if (!el) return;

            e.stopPropagation();
            const userId = el.dataset.userid;
            const invoiceId = el.dataset.invoiceid;

            currentInvoiceUserId = userId;
            currentInvoiceId = invoiceId;

            if (!document.getElementById('sidebar').classList.contains('open')) {
                return;
            }

            fetchInvoiceItems(userId, invoiceId).then(() => {
                openItemsSidebar();
            });
        });

        function openItemsSidebar() {
            const mainSidebar = document.getElementById('sidebar');
            if (!mainSidebar.classList.contains('open')) {
                alert('Please open the main sidebar first.');
                return;
            }

            document.getElementById('itemsSidebar').classList.add('active');
            mainSidebar.style.width = '35%';
            mainSidebar.style.zIndex = '1000';
        }

        function closeItemsSidebar() {
            const itemsSidebar = document.getElementById('itemsSidebar');
            const mainSidebar = document.getElementById('sidebar');

            itemsSidebar.classList.remove('active');
            if (mainSidebar.classList.contains('open')) {
                mainSidebar.style.width = '65%';
            }
        }

        function toggleInvoiceItems() {
            invoiceItemsInclude = invoiceItemsInclude === 1 ? 0 : 1;
            const btn = document.getElementById('toggleInvoiceItemsBtn');

            if (invoiceItemsInclude === 1) {
                btn.innerText = 'Exclude Invoices';
                btn.classList.remove('btn-outline-primary');
                btn.classList.add('btn-primary');
            } else {
                btn.innerText = 'Include Invoices';
                btn.classList.remove('btn-primary');
                btn.classList.add('btn-outline-primary');
            }

            if (currentInvoiceUserId && currentInvoiceId) {
                fetchInvoiceItems(currentInvoiceUserId, currentInvoiceId);
            }
        }

        async function fetchInvoiceItems(userId, invoiceId) {
            const queryParams = {
                userid: userId,
                create_start: currentFilters.date_from,
                create_end: currentFilters.date_to,
                include: invoiceItemsInclude,
                groupby: 'item'
            };

            try {
                const json = await callApi('business_users_invoices', queryParams);
                if (json.rcode !== "success") {
                    alert("Failed to load invoice items");
                    return;
                }

                const filteredItems = (json.invoiceInfo || []).filter(
                    item => String(item.invoiceid) === String(invoiceId)
                );

                renderInvoiceItemTable(filteredItems);

            } catch (err) {
                console.error("Invoice fetch error:", err);
            }
        }

        function renderInvoiceItemTable(items) {
            const container = document.getElementById("invoiceItemsContainer");
            if (!container) return;

            if (!items.length) {
                container.innerHTML = "<p class='text-center'>No items found</p>";
                return;
            }

            const actionLabel = invoiceItemsInclude === 1 ? 'Exclude' : 'Include';
            const actionClass = invoiceItemsInclude === 1 ? 'btn-danger' : 'btn-success';

            let html = `
                <table class="table table-striped table-hover">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Type</th>
                            <th>Description</th>
                            <th>Amount</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
            `;

            items.forEach(item => {
                html += `
                    <tr data-row-itemid="${item.id}">
                        <td>${item.id}</td>
                        <td>${item.type}</td>
                        <td>${item.description || '-'}</td>
                        <td>₹${parseFloat(item.amount).toFixed(2)}</td>
                        <td>
                            <button
                                class="btn ${actionClass} invoice-item-action-btn"
                                data-itemid="${item.id}"
                            >
                                ${actionLabel}
                            </button>
                        </td>
                    </tr>
                `;
            });

            html += `</tbody></table>`;
            container.innerHTML = html;
        }

        document.addEventListener('click', async (e) => {
            const btn = e.target.closest('.invoice-item-action-btn');
            if (!btn) return;

            e.stopPropagation();
            const itemId = btn.dataset.itemid;
            const isIncludeValue = invoiceItemsInclude === 1 ? "0" : "1";

            btn.disabled = true;
            btn.textContent = 'Processing...';

            try {
                const params = {
                    is_include: isIncludeValue,
                    itemid: itemId
                };

                const res = await callApi("update-invoice-item", params, "POST");
                if (res.rcode !== "success") {
                    throw new Error("API failed");
                }

                btn.closest('tr')?.remove();
            } catch (err) {
                console.error(err);
                alert("Failed to update item");
                btn.disabled = false;
                btn.textContent = invoiceItemsInclude === 1 ? 'Exclude' : 'Include';
            }
        });

        function toggleInvoice() {
            includeInvoice = includeInvoice === 1 ? 0 : 1;
            const btn = document.getElementById('invoiceToggleBtn');
            const title = document.getElementById('sidebar-title');

            if (includeInvoice === 1) {
                btn.innerText = 'Exclude Invoices';
                btn.classList.remove('btn-primary');
                btn.classList.add('btn-outline-primary');
                title.innerText = 'Include Invoices';
            } else {
                btn.innerText = 'Include Invoices';
                btn.classList.remove('btn-outline-primary');
                btn.classList.add('btn-primary');
                title.innerText = 'Exclude Invoices';
            }

            if (!currentUserId) {
                console.warn('No user selected yet');
                return;
            }

            showUserInvoices(currentUserId, currentUserName);
        }

        // ============ TARGET MANAGEMENT ============
        const quarterMonthOrder = {
            Q1: ['April', 'May', 'June'],
            Q2: ['July', 'August', 'September'],
            Q3: ['October', 'November', 'December'],
            Q4: ['January', 'February', 'March']
        };

        function convertToQuarterWise(apiData) {
            // console.log(apiData);
            if (!Array.isArray(apiData)) return [];
            const quarterMap = {};

            apiData.forEach(item => {
                const key = `${item.employee_id}-${item.year}-${item.quarter}`;
                if (!quarterMap[key]) {
                    const months = quarterMonthOrder[item.quarter] || [];
                    quarterMap[key] = {
                        id: `target-${Object.keys(quarterMap).length + 1}`,
                        rep: item.employee_name,
                        year: item.year,
                        quarter: `${item.quarter} (${months.join('-')})`,
                        totalTargetBusiness: 0,
                        totalTargetMRR: 0,
                        achievedBusiness: 0,
                        achievedMRR: 0,
                        months: {}
                    };
                }

                quarterMap[key].months[item.month] = item;
                quarterMap[key].totalTargetBusiness += Number(item.target_business || 0);
                quarterMap[key].totalTargetMRR += Number(item.target_mrr || 0);
                quarterMap[key].achievedBusiness += Number(item.achived_buisness || 0);
                quarterMap[key].achievedMRR += Number(item.achived_mrr || 0);
            });

            return Object.values(quarterMap).map(q => {
                const qKey = q.quarter.split(' ')[0];
                const order = quarterMonthOrder[qKey] || [];
                const m1 = q.months[order[0]] || {};
                const m2 = q.months[order[1]] || {};
                const m3 = q.months[order[2]] || {};
                const achievementPercent = q.totalTargetBusiness
                    ? Math.round((q.achievedBusiness / q.totalTargetBusiness) * 100)
                    : 0;

                return {
                    id: q.id,
                    rep: q.rep,
                    year: q.year,
                    quarter: q.quarter,
                    wholeTotalTarget: formatINR(q.totalTargetBusiness),
                    targetMRR: formatINR(q.totalTargetMRR),
                    wholeMonth1: formatINR(m1.target_business),
                    wholeMonth2: formatINR(m2.target_business),
                    wholeMonth3: formatINR(m3.target_business),
                    mrrMonth1: formatINR(m1.target_mrr),
                    mrrMonth2: formatINR(m2.target_mrr),
                    mrrMonth3: formatINR(m3.target_mrr),
                    achievedRevenue: formatINR(q.achievedBusiness),
                    achievedMRR: formatINR(q.achievedMRR),
                    achievement: `${achievementPercent}%`,
                    status: getStatusFromAchievement(achievementPercent)
                };
            });
        }

        function getStatusFromAchievement(percent) {
            if (percent >= 100) return 'Ahead';
            if (percent >= 85) return 'On Track';
            if (percent >= 70) return 'Behind';
            return 'At Risk';
        }

        function getStatusClass(status) {
            switch (status) {
                case 'Ahead': return 'ahead';
                case 'On Track': return 'on-track';
                case 'Behind': return 'behind';
                case 'At Risk': return 'at-risk';
                default: return 'at-risk';
            }
        }

        function getProgressColor(status) {
            switch (status) {
                case 'On Track': return '#10B981';
                case 'Behind': return '#EF4444';
                case 'At Risk': return '#F59E0B';
                default: return '#10B981';
            }
        }

        function renderTargetsTable(targets) {
            const tbody = document.querySelector('#targetsTable tbody');
            tbody.innerHTML = targets.map((target, index) => `
                <tr data-id="${target.id || index}" onclick="editTarget(${JSON.stringify(target).replace(/"/g, '&quot;')})">
                    <td>${index + 1}</td>
                    <td>${target.year}</td>
                    <td>${target.quarter}</td>
                    <td>${target.wholeTotalTarget || target.targetBusiness}</td>
                    <td>${target.targetMRR}</td>
                    <td style="text-align: center;">${target.wholeMonth1 || '-'}</td>
                    <td style="text-align: center;">${target.wholeMonth2 || '-'}</td>
                    <td style="text-align: center;">${target.wholeMonth3 || '-'}</td>
                    <td style="text-align: center;">${target.mrrMonth1 || '-'}</td>
                    <td style="text-align: center;">${target.mrrMonth2 || '-'}</td>
                    <td style="text-align: center;">${target.mrrMonth3 || '-'}</td>
                    <td>${target.achievedRevenue || target.achievedWhole}</td>
                    <td>${target.achievedMRR}</td>
                    <td>
                        <div style="display: flex; align-items: center; gap: 8px;">
                            <div class="progress-bar-custom">
                                <div class="progress-fill" style="width: ${target.achievement}; background: ${getProgressColor(target.status)};"></div>
                            </div>
                            <span style="font-weight: 600;">${target.achievement}</span>
                        </div>
                    </td>
                    <td><span class="badge ${getStatusClass(target.status)}">${target.status}</span></td>
                    <td><button class="btn btn-sm btn-warning" onclick="event.stopPropagation(); manageTarget(${JSON.stringify(target).replace(/"/g, '&quot;')})">Manage</button></td>
                </tr>
            `).join('');
        }

        // ============ TARGET MODAL FUNCTIONS ============
        let currentTargetData = null;

        function openEditModal(target = null) {
            const modal = document.getElementById('editTargetModal');
            modal.classList.add('show');

            const title = document.getElementById('editTargetModalTitle');
            const submitBtn = document.getElementById('editTargetSubmitBtn');

            if (target) {
                currentTargetData = target;
                title.textContent = 'Update Target';
                submitBtn.textContent = 'Update Target';
                document.getElementById('targetId').value = target.id || '';
                document.getElementById('targetYear').value = target.year || '';
                const quarterValue = target.quarter?.split(' ')[0];
                document.getElementById('targetQuarter').value = quarterValue || '';
                document.getElementById('wholeTotalTarget').value = parseAmount(target.wholeTotalTarget);
            } else {
                currentTargetData = null;
                title.textContent = 'Add Target';
                submitBtn.textContent = 'Save Target';
                document.getElementById('editTargetForm').reset();
            }
        }

        function closeEditModal() {
            const modal = document.getElementById('editTargetModal');
            modal.classList.remove('show');
            currentTargetData = null;
        }

        function parseAmount(amountStr) {
            if (typeof amountStr === 'number') return amountStr;
            if (!amountStr) return 0;
            const cleaned = amountStr.replace(/[₹,\s]/g, '');
            if (cleaned.includes('Lk') || cleaned.includes('L')) {
                return parseFloat(cleaned.replace(/Lk|L/g, '')) * 100000;
            }
            if (cleaned.includes('K')) {
                return parseFloat(cleaned.replace('K', '')) * 1000;
            }
            return parseFloat(cleaned) || 0;
        }

        function editTarget(target) {
            openEditModal(target);
        }

        async function saveTarget(event) {
            event.preventDefault();
            const form = document.getElementById('editTargetForm');
            if (!form.checkValidity()) {
                form.reportValidity();
                return;
            }

            const year = document.getElementById('targetYear').value;
            const quarter = document.getElementById('targetQuarter').value;
            const wholeTotalTarget = document.getElementById('wholeTotalTarget').value;

            const data = {
                year: year,
                quarter: quarter,
                total_sales_target: wholeTotalTarget
            };

            const isEdit = !!currentTargetData;
            const method = isEdit ? 'PUT' : 'POST';

            try {
                const response = await callApi('sales-target', data, method);
                if (response && response.rcode === 'success') {
                    closeEditModal();
                    loadDashboard();
                    softAlert(`Target ${isEdit ? 'updated' : 'saved'} successfully`, 'success');
                } else {
                    softAlert(response?.rmessage || 'Something went wrong', 'error');
                }
            } catch (error) {
                console.error(error);
                softAlert('Error saving target', 'error');
            }
        }

        // ============ TEAM TARGET FUNCTIONS ============
        async function manageTarget(target) {
            currentTeamTarget = target;
            const quarterMatch = target.quarter?.match(/Q\d/);
            const quarter = quarterMatch ? quarterMatch[0] : 'Q1';
            const year = target.year || '2026';

            document.getElementById('teamTargetHeader').textContent =
                `Team Targets of Quarter - ${quarter} of ${year}`;

            document.getElementById('teamTargetLoading').style.display = 'block';
            document.getElementById('teamTargetsTableContainer').style.display = 'none';
            document.getElementById('teamTargetFormContainer').style.display = 'none';

            await loadTeamTargets(quarter, year);
            openTeamTargetSidebar();
        }

        async function loadTeamTargets(quarter, year) {
            try {
                const tbody = document.getElementById('teamTargetsTableBody');
                tbody.innerHTML = '';

                document.getElementById('teamTargetLoading').style.display = 'block';
                document.getElementById('teamTargetsTableContainer').style.display = 'none';

                const response = await callApi('employee-sales-target');
                if (!response?.data || !Array.isArray(response.data)) {
                    throw new Error('Invalid API response');
                }

                const filteredTargets = response.data.filter(item =>
                    String(item.year) === String(year) &&
                    String(item.quarter) === String(quarter)
                );

                if (filteredTargets.length === 0) {
                    tbody.innerHTML = `
                        <tr>
                            <td colspan="8" style="text-align:center; padding:40px; color:#6b7280;">
                                No team targets found for ${quarter} ${year}
                            </td>
                        </tr>
                    `;
                } else {
                    filteredTargets.forEach((target, index) => {
                        const row = document.createElement('tr');
                        row.style.cursor = 'pointer';
                        row.onclick = () => editTeamTarget(target);

                        row.innerHTML = `
                            <td style="padding:12px;">${index + 1}</td>
                            <td style="padding:12px; font-weight:600;">
                                ${target.employee_name || 'N/A'}
                            </td>
                            <td style="padding:12px;">${target.year}</td>
                            <td style="padding:12px;">${target.quarter}</td>
                            <td style="padding:12px; color:var(--primary-color); font-weight:600;">
                                ${target.assigned_sales_target}
                            </td>
                            <td style="padding:12px;">${target.month_1 || 0}</td>
                            <td style="padding:12px;">${target.month_2 || 0}</td>
                            <td style="padding:12px;">${target.month_3 || 0}</td>
                        `;

                        tbody.appendChild(row);
                    });
                }

                document.getElementById('teamTargetLoading').style.display = 'none';
                document.getElementById('teamTargetsTableContainer').style.display = 'block';

            } catch (error) {
                console.error("Error loading team targets:", error);
                document.getElementById('teamTargetLoading').style.display = 'none';
                document.getElementById('teamTargetsTableContainer').innerHTML = `
                    <div style="text-align:center; padding:20px; color:#ef4444;">
                        Error loading team targets. Please try again.
                    </div>
                `;
            }
        }

        function showTeamTargetForm() {
            document.getElementById('teamTargetsTableContainer').style.display = 'none';
            document.getElementById('teamTargetFormContainer').style.display = 'block';

            if (currentTeamTarget) {
                const quarterMatch = currentTeamTarget.quarter?.match(/Q\d/);
                if (quarterMatch) {
                    document.getElementById('targetQuarterForm').value = quarterMatch[0];
                }
                if (currentTeamTarget.year) {
                    document.getElementById('targetYearForm').value = currentTeamTarget.year;
                }
            }
        }

        function hideTeamTargetForm() {
            document.getElementById('teamTargetFormContainer').style.display = 'none';
            document.getElementById('teamTargetsTableContainer').style.display = 'block';
        }

        async function handleTeamTargetSubmit(event) {
            event.preventDefault();

            const employeeId = document.getElementById('teamMemberSelect').value;
            const year = document.getElementById('targetYearForm').value;
            const quarter = document.getElementById('targetQuarterForm').value;
            const targetAmount = document.getElementById('targetAmount').value;

            if (!employeeId || !year || !quarter || !targetAmount) {
                softAlert('Please fill all required fields', 'warning');
                return;
            }

            const payload = {
                employee_id: employeeId,
                year: year,
                quarter: quarter,
                assigned_sales_target: targetAmount
            };

            const submitBtn = event.target.querySelector('.btn-save');
            const originalText = submitBtn.textContent;

            try {
                submitBtn.textContent = 'Updating...';
                submitBtn.disabled = true;

                const isEdit = !!window.currentEditingTarget;
                const response = await callApi(
                    'employee-sales-target',
                    payload,
                    isEdit ? 'PUT' : 'POST'
                );

                if (!response || response.status === false) {
                    throw new Error(response?.message || 'Update failed');
                }

                softAlert(`Team target ${isEdit ? 'updated' : 'added'} successfully`, 'success');
                await loadTeamTargets(quarter, year);
                resetTeamTargetForm();

            } catch (error) {
                console.error(error);
                softAlert(error.message || 'Something went wrong', 'error');
            } finally {
                submitBtn.textContent = originalText;
                submitBtn.disabled = false;
            }
        }

        function resetTeamTargetForm() {
            document.getElementById('teamTargetForm').reset();
            document.getElementById('teamMemberSelect').disabled = false;
            document.getElementById('targetYearForm').disabled = false;
            document.getElementById('targetQuarterForm').disabled = false;

            const submitBtn = document.querySelector('#teamTargetForm .btn-save');
            submitBtn.textContent = 'Add Team Target';

            window.currentEditingTarget = null;
            hideTeamTargetForm();
        }

        function editTeamTarget(target) {
            console.log("Edit team target:", target);
            window.currentEditingTarget = target;

            document.getElementById('teamMemberSelect').value = target.employee_id;
            document.getElementById('targetYearForm').value = target.year;
            document.getElementById('targetQuarterForm').value = target.quarter;
            document.getElementById('targetAmount').value =
                String(target.overall_target).replace(/[₹,]/g, '');

            document.getElementById('teamMemberSelect').disabled = true;
            document.getElementById('targetYearForm').disabled = true;
            document.getElementById('targetQuarterForm').disabled = true;

            const submitBtn = document.querySelector('#teamTargetForm .btn-save');
            submitBtn.textContent = 'Update Team Target';

            showTeamTargetForm();
        }

        function openTeamTargetSidebar() {
            document.getElementById('teamTargetOverlay').classList.add('show');
            document.getElementById('teamTargetSidebar').classList.add('show');
        }

        function closeTeamTargetSidebar() {
            document.getElementById('teamTargetOverlay').classList.remove('show');
            document.getElementById('teamTargetSidebar').classList.remove('show');
            currentTeamTarget = null;
        }

        // ============ DEALS FUNCTIONS ============
        function toggleDealsTable(dealType) {
            const lostTable = document.getElementById('dealsLostTable');
            const wonTable = document.getElementById('dealsWonTable');

            if (dealType === 'lost') {
                lostTable.style.display = 'block';
                wonTable.style.display = 'none';
            } else {
                lostTable.style.display = 'none';
                wonTable.style.display = 'block';
            }
        }

        async function applyDealsFilter(dealType) {
            const dealStageId = dealType === 'lost' ? 155 : 154;
            const { sales_person, date_from, date_to } = currentFilters;

            try {
                const dealData = await callApi('deal', {
                    userid: sales_person,
                    create_start: date_from,
                    create_end: date_to,
                    deal_stage_id: dealStageId
                });

                if (dealType === 'lost') {
                    populateDealsTable(dealData, 'dealsLostTableBody');
                    toggleDealsTable('lost');
                } else {
                    populateDealsTable(dealData, 'dealsWonTableBody');
                    toggleDealsTable('won');
                }
            } catch (error) {
                console.error('Error fetching deals:', error);
                const tableBodyId = dealType === 'lost' ? 'dealsLostTableBody' : 'dealsWonTableBody';
                document.getElementById(tableBodyId).innerHTML =
                    `<tr><td colspan="7" class="text-center">Error loading deals</td></tr>`;
            }
        }

        function populateDealsTable(deals, tableBodyId) {
            const tbody = document.getElementById(tableBodyId);
            if (!deals || !deals.deals || deals.deals.length === 0) {
                tbody.innerHTML = `<tr><td colspan="7" class="text-center">No deals found</td></tr>`;
                return;
            }

            tbody.innerHTML = deals.deals.map((deal, index) => `
                <tr>
                    <td>${index + 1}</td>
                    <td>${deal.id || 'N/A'}</td>
                    <td>${(deal.contact_first_name || '') + ' ' + (deal.contact_last_name || '') || 'N/A'}</td>
                    <td>${deal.name || 'N/A'}</td>
                    <td>${deal.amount || 'N/A'}</td>
                    <td>${deal.assignedto_name || 'N/A'}</td>
                    <td>
                        <span class="badge ${tableBodyId === 'dealsLostTableBody' ? 'at-risk' : 'success'}">
                            ${tableBodyId === 'dealsLostTableBody' ? deal.deal_stage : deal.deal_stage}
                        </span>
                    </td>
                </tr>
            `).join('');
        }

        // ============ CONTACT SIDEBAR ============
        async function openContactSidebar(contactId) {
            try {
                currentContactId = contactId;
                const [contact, activities, notes, calls, logs] = await Promise.all([
                    callApi(`contact/${contactId}`),
                    callApi("followup", {
                        department: "Sales",
                        ref_type: "contact",
                        ref_id: contactId
                    }),
                    callApi("note", {
                        ref_type: "salecontact",
                        ref_id: contactId
                    }),
                    callApi("call", {
                        contactid: contactId
                    }),
                    callApi("log", {
                        ref_type: "contact",
                        ref_id: contactId
                    })
                ]);

                const firstName = safeGet(contact, 'first_name', '');
                const lastName = safeGet(contact, 'last_name', '');
                const fullName = `${firstName} ${lastName}`.trim() || 'No Name';

                document.getElementById('contactFullName').textContent = fullName;
                document.getElementById('firstName').textContent = firstName;
                document.getElementById('lastName').textContent = lastName;
                document.getElementById('jobTitle').textContent = safeGet(contact, 'job_title', '');
                document.getElementById('mobile').textContent = safeGet(contact, 'mobile_number') || safeGet(contact, 'mobile', '');
                document.getElementById('email').textContent = safeGet(contact, 'email', '');
                document.getElementById('city').textContent = safeGet(contact, 'city', '');
                document.getElementById('state').textContent = safeGet(contact, 'state', '');
                document.getElementById('country').textContent = safeGet(contact, 'country', '');
                document.getElementById('owner').textContent = safeGet(contact, 'assigned_to_name') || safeGet(contact, 'owner_id', '');
                document.getElementById('status').textContent = safeGet(contact, 'contact_status') || safeGet(contact, 'contact_status_id', '');
                document.getElementById('source').textContent = safeGet(contact, 'source', '');
                document.getElementById('medium').textContent = safeGet(contact, 'medium', '');

                populateActivityTab(activities);
                populateNotesTab(notes);
                populateCallsTab(calls);
                populateLogsTab(logs);
                setupFollowupForm();

                document.getElementById('sidebarOverlay').classList.add('show');
                document.getElementById('contactSidebar').classList.add('show');

            } catch (error) {
                console.error("Contact sidebar error:", error);
                softAlert("Error loading contact details. Please try again.", "error");
            }
        }

        function populateActivityTab(activities) {
            const activityContent = document.getElementById('activityContent');

            if (activities && activities.followups && activities.followups.length > 0) {
                activityContent.innerHTML = activities.followups.map(activity => {
                    const followupDate = new Date(activity.followuptime);
                    const formattedFollowupTime = `${followupDate.getHours().toString().padStart(2, '0')}:${followupDate.getMinutes().toString().padStart(2, '0')}-${(followupDate.getMonth() + 1).toString().padStart(2, '0')}-${followupDate.getDate().toString().padStart(2, '0')} ${followupDate.getHours().toString().padStart(2, '0')}:${followupDate.getMinutes().toString().padStart(2, '0')}:${followupDate.getSeconds().toString().padStart(2, '0')}`;

                    const isCompleted = activity.status_text === 'Completed';
                    const checkmark = isCompleted ? '✔' : '○';
                    const checkmarkColor = isCompleted ? '#10b981' : '#6b7280';

                    return `
                        <div style="display: flex; gap: 12px; margin-bottom: 16px;">
                            <div style="color: ${checkmarkColor}; font-size: 16px; margin-top: 2px;">${checkmark}</div>
                            <div style="flex: 1;">
                                <div style="display: flex; justify-content: space-between; margin-bottom: 4px;">
                                    <span style="font-weight: 500; font-size: 13px;">${activity.followup_admin_name || 'Unknown'}</span>
                                    <span style="color: #6b7280; font-size: 12px;">at ${activity.entrytime || ''}</span>
                                </div>
                                <div style="color: #6b7280; font-size: 12px; margin-bottom: 4px;">${formattedFollowupTime}</div>
                                <div style="font-size: 13px;">${activity.message || ''}</div>
                            </div>
                        </div>
                    `;
                }).join('');
            } else {
                activityContent.innerHTML = `
                    <div style="text-align: center; padding: 40px; color: #6b7280; font-size: 13px;">
                        No activities available
                    </div>
                `;
            }
        }

        function populateNotesTab(notes) {
            const notesContent = document.getElementById('notesContent');

            if (notes && notes.notes && notes.notes.length > 0) {
                notesContent.innerHTML = notes.notes.map(note => `
                    <div style="padding: 16px; border-bottom: 1px solid #e5e7eb; margin-bottom: 12px;">
                        <div style="font-size: 13px; margin-bottom: 8px;">${note.content || ''}</div>
                        <div style="display: flex; justify-content: space-between; font-size: 11px; color: #6b7280;">
                            <span>${note.created_by || 'Unknown'}</span>
                            <span>${note.created_at || ''}</span>
                        </div>
                    </div>
                `).join('');
            } else {
                notesContent.innerHTML = `
                    <p style="color: #6b7280; font-size: 13px;">No notes available</p>
                `;
            }
        }

        function populateCallsTab(calls) {
            const callsContent = document.getElementById('callsContent');

            if (calls && calls.calls && calls.calls.length > 0) {
                callsContent.innerHTML = calls.calls.map(call => `
                    <tr>
                        <td style="padding: 12px 16px; border-bottom: 1px solid #e5e7eb;">${call.time || ''}</td>
                        <td style="padding: 12px 16px; border-bottom: 1px solid #e5e7eb;">${call.type || ''}</td>
                        <td style="padding: 12px 16px; border-bottom: 1px solid #e5e7eb;">${call.caller || ''}</td>
                        <td style="padding: 12px 16px; border-bottom: 1px solid #e5e7eb;">${call.receiver || ''}</td>
                        <td style="padding: 12px 16px; border-bottom: 1px solid #e5e7eb;">${call.status || ''}</td>
                        <td style="padding: 12px 16px; border-bottom: 1px solid #e5e7eb;">${call.duration || ''}</td>
                    </tr>
                `).join('');
            } else {
                callsContent.innerHTML = `
                    <tr>
                        <td colspan="6" style="text-align: center; padding: 40px; color: #6b7280; font-size: 13px;">
                            No call logs available
                        </td>
                    </tr>
                `;
            }
        }

        function populateLogsTab(logs) {
            const logsContent = document.getElementById('logsContent');

            if (logs && logs.logs && logs.logs.length > 0) {
                logsContent.innerHTML = logs.logs.map(log => `
                    <tr>
                        <td style="padding: 12px 16px; border-bottom: 1px solid #e5e7eb;">${log.action || ''}</td>
                        <td style="padding: 12px 16px; border-bottom: 1px solid #e5e7eb;">${log.actby || ''}</td>
                        <td style="padding: 12px 16px; border-bottom: 1px solid #e5e7eb;">${log.date || ''}</td>
                    </tr>
                `).join('');
            } else {
                logsContent.innerHTML = `
                    <tr>
                        <td colspan="3" style="text-align: center; padding: 40px; color: #6b7280; font-size: 13px;">
                            No activity logs available
                        </td>
                    </tr>
                `;
            }
        }

        function setupFollowupForm() {
            const now = new Date();
            const formattedDate = now.toISOString().split('T')[0];
            document.getElementById('dueAtDate').value = formattedDate;
            document.getElementById('dueAtType').value = "Call";
        }

        async function addFollowup() {
            const message = document.getElementById('followupMessage').value.trim();
            const dueAtDate = document.getElementById('dueAtDate').value;
            const dueAtType = document.getElementById('dueAtType').value;

            if (!message) {
                alert("Please enter a follow-up message");
                return;
            }

            if (!currentContactId) {
                alert("No contact selected");
                return;
            }

            try {
                const data = {
                    department: "Sales",
                    ref_type: "contact",
                    ref_id: currentContactId,
                    message: message,
                    followuptime: dueAtDate + " 00:00:00",
                    type: dueAtType === "Call" ? "4" : "1",
                    status: "24"
                };

                const response = await callApi("followup", data, "POST");
                if (response && response.rcode === "success") {
                    document.getElementById('followupMessage').value = "";
                    const activities = await callApi("followup", {
                        department: "Sales",
                        ref_type: "contact",
                        ref_id: currentContactId
                    });
                    populateActivityTab(activities);
                    alert("Follow-up added successfully!");
                } else {
                    alert("Error adding follow-up: " + (response.rmessage || "Unknown error"));
                }
            } catch (error) {
                console.error("Error adding follow-up:", error);
                alert("Error adding follow-up. Please try again.");
            }
        }

        function closeNote() {
            switchTab('activity');
        }

        function closeCalls() {
            switchTab('activity');
        }

        function closeContactSidebar() {
            document.getElementById('sidebarOverlay').classList.remove('show');
            document.getElementById('contactSidebar').classList.remove('show');
            currentContactId = null;
        }

        function switchTab(tabName) {
            document.querySelectorAll('.sidebar-tab').forEach(tab => {
                tab.classList.remove('active');
            });
            document.querySelectorAll('.tab-content').forEach(content => {
                content.classList.remove('active');
            });

            const clickedTab = event.target.closest('.sidebar-tab');
            if (clickedTab) {
                clickedTab.classList.add('active');
            }
            document.getElementById(tabName + '-tab').classList.add('active');
        }

        // ============ ACTIVITY FUNCTIONS ============
        function renderActivity(activities) {
            const timeline = document.getElementById('activityTimeline');

            if (!activities || activities.length === 0) {
                timeline.innerHTML = `
                    <div class="activity-item">
                        <div class="activity-content">
                            <p>No recent activity found</p>
                            <small>Activity will appear here as it happens</small>
                        </div>
                    </div>
                `;
                return;
            }

            const activityItems = [];
            activities.forEach((activity) => {
                if (!activity) return;
                const taskText = safeGet(activity, 'task') ||
                    safeGet(activity, 'action') ||
                    safeGet(activity, 'description') ||
                    'Activity logged';

                const user = extractUserName(taskText) || 'Admin';
                const ip = safeGet(activity, 'ip') || safeGet(activity, 'ip_address', '');
                const time = safeGet(activity, 'time') ||
                    safeGet(activity, 'created_at') ||
                    safeGet(activity, 'date', '');

                let timeDisplay = 'Recently';
                if (time) {
                    try {
                        const activityTime = new Date(time);
                        if (!isNaN(activityTime.getTime())) {
                            const now = new Date();
                            const diffMs = now - activityTime;
                            const diffMins = Math.floor(diffMs / (1000 * 60));
                            const diffHours = Math.floor(diffMs / (1000 * 60 * 60));
                            const diffDays = Math.floor(diffMs / (1000 * 60 * 60 * 24));

                            if (diffMins < 60) {
                                timeDisplay = `${diffMins}m ago`;
                            } else if (diffHours < 24) {
                                timeDisplay = `${diffHours}h ago`;
                            } else if (diffDays === 1) {
                                timeDisplay = 'Yesterday';
                            } else if (diffDays < 7) {
                                timeDisplay = `${diffDays}d ago`;
                            } else {
                                timeDisplay = activityTime.toLocaleDateString('en-US', {
                                    month: 'short',
                                    day: 'numeric'
                                });
                            }
                        }
                    } catch (e) {
                        console.error('Error parsing time:', e);
                    }
                }

                activityItems.push({
                    type: taskText.includes('Logout') ? 'logout' : 'login',
                    user: user,
                    description: taskText,
                    details: ip ? `IP: ${ip}` : '',
                    time: timeDisplay
                });
            });

            if (activityItems.length === 0) {
                timeline.innerHTML = `
                    <div class="activity-item">
                        <div class="activity-content">
                            <p>No activity items to display</p>
                        </div>
                    </div>
                `;
                return;
            }

            timeline.innerHTML = activityItems.map(activity => {
                const iconData = {
                    call: { icon: 'bi-telephone-fill', bg: '#DBEAFE', color: '#1E40AF' },
                    email: { icon: 'bi-envelope-fill', bg: '#FEF3C7', color: '#92400E' },
                    meeting: { icon: 'bi-calendar-event-fill', bg: '#D1FAE5', color: '#065F46' },
                    deal: { icon: 'bi-trophy-fill', bg: '#FEE2E2', color: '#991B1B' },
                    login: { icon: 'bi-box-arrow-in-right', bg: '#D1FAE5', color: '#065F46' },
                    logout: { icon: 'bi-box-arrow-right', bg: '#FEE2E2', color: '#991B1B' }
                }[activity.type] || { icon: 'bi-info-circle', bg: '#E5E7EB', color: '#6B7280' };

                return `
                    <div class="activity-item">
                        <div class="activity-icon" style="background: ${iconData.bg}; color: ${iconData.color};">
                            <i class="bi ${iconData.icon}"></i>
                        </div>
                        <div class="activity-content">
                            <p><strong>${activity.user || 'Unknown'}</strong> ${activity.description || ''}</p>
                            ${activity.details ? `<small>${activity.details}</small>` : ''}
                        </div>
                        <div class="activity-time">${activity.time}</div>
                    </div>
                `;
            }).join('');
        }

        function extractUserName(taskText) {
            if (!taskText) return 'Admin';
            const userMatch = taskText.match(/Admin User (\w+)/);
            return userMatch && userMatch[1] ? userMatch[1] : 'Admin';
        }

        // ============ TASK FILTER FUNCTIONS ============
        async function applyTasksFilter() {
            currentTaskFilters = {
                department: document.getElementById('filterDepartment').value,
                status: document.getElementById('filterStatus').value,
                ref_type: document.getElementById('filterRefType').value,
                ref_id: document.getElementById('filterRefId').value
            };

            await loadFilteredTasks();
        }

        function clearTasksFilter() {
            document.getElementById('filterDepartment').value = '';
            document.getElementById('filterStatus').value = '';
            document.getElementById('filterRefType').value = '';
            document.getElementById('filterRefId').value = '';

            currentTaskFilters = {
                department: '',
                status: '',
                ref_type: '',
                ref_id: ''
            };
            currentCategory = '';

            loadTasksWithMainFilters();
        }

        async function loadFilteredTasks() {
            try {
                let params = {
                    mytickets: 0,
                    status: 24
                };

                if (mainFilters.sales_person) {
                    params.followup_admin = mainFilters.sales_person;
                }

                if (mainFilters.date_from) {
                    params.date_start = mainFilters.date_from;
                }
                if (mainFilters.date_to) {
                    params.date_end = mainFilters.date_to;
                }

                if (currentCategory) {
                    await applyCategoryDateFilter(params, currentCategory);
                }

                if (currentTaskFilters.department) {
                    params.department = currentTaskFilters.department;
                }
                if (currentTaskFilters.status) {
                    params.status = currentTaskFilters.status;
                }
                if (currentTaskFilters.ref_type) {
                    params.ref_type = currentTaskFilters.ref_type;
                }
                if (currentTaskFilters.ref_id) {
                    params.ref_id = currentTaskFilters.ref_id;
                }

                const data = await callApi("followup", params);
                filteredTasks = data?.followups || [];
                allTasks = filteredTasks;
                currentPage = 1;
                renderTasks(currentPage);

            } catch (error) {
                console.error("Filter API error:", error);
            }
        }

        async function filterTasksByCategory(category) {
            currentCategory = category;
            currentPage = 1;
            mainFilters = getMainFilters();

            let params = {
                mytickets: 0,
                status: 24
            };

            if (mainFilters.sales_person) {
                params.followup_admin = mainFilters.sales_person;
            }

            await applyCategoryDateFilter(params, category);

            if (!params.date_start && mainFilters.date_from) {
                params.date_start = mainFilters.date_from;
            }
            if (!params.date_end && mainFilters.date_to) {
                params.date_end = mainFilters.date_to;
            }

            if (currentTaskFilters.department) {
                params.department = currentTaskFilters.department;
            }
            if (currentTaskFilters.status) {
                params.status = currentTaskFilters.status;
            }
            if (currentTaskFilters.ref_type) {
                params.ref_type = currentTaskFilters.ref_type;
            }
            if (currentTaskFilters.ref_id) {
                params.ref_id = currentTaskFilters.ref_id;
            }

            try {
                const data = await callApi("followup", params);
                filteredTasks = data?.followups || [];
                allTasks = filteredTasks;
                renderTasks(currentPage);
            } catch (error) {
                console.error("Filter API error:", error);
            }
        }

        async function applyCategoryDateFilter(params, category) {
            if (category.toLowerCase() === "overdue") {
                const DateObj = new Date();
                DateObj.setDate(DateObj.getDate() - 1);
                const endDate = DateObj.toISOString().split('T')[0];
                params.date_end = endDate;
            } else if (category.toLowerCase() === "today") {
                const DateObj = new Date();
                DateObj.setDate(DateObj.getDate() - 1);
                const startDate = DateObj.toISOString().split('T')[0];
                const endDate = DateObj.toISOString().split('T')[0];
                params.date_start = startDate;
                params.date_end = endDate;
            } else if (category.toLowerCase() === "week") {
                const dateObj = new Date();
                const startDate = dateObj.toISOString().split('T')[0];
                dateObj.setDate(dateObj.getDate() + 7);
                const endDate = dateObj.toISOString().split('T')[0];
                params.date_start = startDate;
                params.date_end = endDate;
            } else if (category.toLowerCase() === "next30") {
                const dateObj = new Date();
                const startDate = dateObj.toISOString().split('T')[0];
                dateObj.setDate(dateObj.getDate() + 30);
                const endDate = dateObj.toISOString().split('T')[0];
                params.date_start = startDate;
                params.date_end = endDate;
            }
        }

        async function loadTasksWithMainFilters() {
            try {
                mainFilters = getMainFilters();
                let params = {
                    mytickets: 0,
                    status: 24
                };

                if (mainFilters.sales_person) {
                    params.followup_admin = mainFilters.sales_person;
                }
                if (mainFilters.date_from) {
                    params.date_start = mainFilters.date_from;
                }
                if (mainFilters.date_to) {
                    params.date_end = mainFilters.date_to;
                }

                const data = await callApi("followup", params);
                filteredTasks = data?.followups || [];
                allTasks = filteredTasks;
                currentPage = 1;
                renderTasks(currentPage);
            } catch (error) {
                console.error("Error loading tasks with main filters:", error);
            }
        }

        // ============ LOGOUT FUNCTION ============
        async function logout() {
            try {
                const confirmLogout = confirm("Are you sure you want to logout?");
                if (!confirmLogout) return;

                showLoader('Logging out...');

                const envs = ['dev', 'prod'];
                envs.forEach(env => {
                    sessionStorage.removeItem(`auth_token_${env}`);
                    sessionStorage.removeItem(`username_${env}`);
                    localStorage.removeItem(`auth_token_${env}`);
                    localStorage.removeItem(`username_${env}`);
                });

                sessionStorage.removeItem('auth_token');
                sessionStorage.removeItem('username');
                localStorage.removeItem('auth_token');
                localStorage.removeItem('username');

                localStorage.removeItem('user_data');
                sessionStorage.removeItem('user_data');

                document.cookie.split(";").forEach(function (c) {
                    document.cookie = c.replace(/^ +/, "")
                        .replace(/=.*/, "=;expires=" + new Date().toUTCString() + ";path=/");
                });

                document.cookie = "envType=; expires=Thu, 01 Jan 1970 00:00:00 UTC; path=/;";

                softAlert('Logged out successfully!', 'success', 2000);

                setTimeout(() => {
                    window.location.href = '/login/login.php';
                }, 1500);

            } catch (error) {
                console.error('Logout error:', error);
                softAlert('Error during logout', 'error');
                hideLoader();
            }
        }

        // ============ UI HELPER FUNCTIONS ============
        function softAlert(message, type = 'success', duration = 3000) {
            const alert = document.createElement('div');
            alert.className = `soft-alert ${type}`;
            alert.textContent = message;

            document.body.appendChild(alert);

            setTimeout(() => alert.classList.add('show'), 50);
            setTimeout(() => {
                alert.classList.remove('show');
                setTimeout(() => alert.remove(), 300);
            }, duration);
        }

        function showLoader(text = 'Loading...') {
            const loader = document.getElementById('globalLoader');
            const loaderText = document.getElementById('loaderText');

            if (loader && loaderText) {
                loaderText.textContent = text;
                loader.classList.add('active');
                document.body.style.overflow = 'hidden';
            }
        }

        function hideLoader() {
            const loader = document.getElementById('globalLoader');
            if (loader) {
                loader.classList.remove('active');
                document.body.style.overflow = '';
            }
        }

        function setButtonLoading(button, isLoading) {
            if (!button) return;
            if (isLoading) {
                button.classList.add('btn-loading');
                button.disabled = true;
            } else {
                button.classList.remove('btn-loading');
                button.disabled = false;
            }
        }

        // ============ EVENT LISTENER SETUP ============
        function setupEventListeners() {
            // Team target form submission
            const teamTargetForm = document.getElementById('teamTargetForm');
            if (teamTargetForm) {
                teamTargetForm.addEventListener('submit', handleTeamTargetSubmit);
            }

            // Logout buttons
            const logoutBtn = document.querySelector('[onclick*="logout"]');
            if (logoutBtn) {
                logoutBtn.removeAttribute('onclick');
                logoutBtn.addEventListener('click', function (e) {
                    e.preventDefault();
                    logout();
                });
            }

            // Report button
            const reportBtn = document.getElementById('getReportBtn');
            if (reportBtn) {
                reportBtn.addEventListener('click', function (e) {
                    e.preventDefault();
                    const formData = getFormData();
                    loadKPIReport(formData);

                    // Refresh tasks if visible
                    const tasksTableWrapper = document.getElementById('tasksTableWrapper');
                    if (tasksTableWrapper.style.display === 'block') {
                        if (currentTaskFilters.department || currentTaskFilters.status ||
                            currentTaskFilters.ref_type || currentTaskFilters.ref_id) {
                            loadFilteredTasks();
                        } else if (currentCategory) {
                            filterTasksByCategory(currentCategory);
                        } else {
                            loadTasksWithMainFilters();
                        }
                    }
                });
            }

            // Set initial dates
            const today = new Date();
            const month = today.getMonth() + 1;
            const year = today.getFullYear();

            let startDate = "";
            let endDate = "";

            if (month >= 4 && month <= 6) {
                startDate = `${year}-04-01`;
                endDate = `${year}-06-30`;
            } else if (month >= 7 && month <= 9) {
                startDate = `${year}-07-01`;
                endDate = `${year}-09-30`;
            } else if (month >= 10 && month <= 12) {
                startDate = `${year}-10-01`;
                endDate = `${year}-12-31`;
            } else {
                startDate = `${year}-01-01`;
                endDate = `${year}-03-31`;
            }

            document.getElementById("date_from").value = startDate;
            document.getElementById("date_to").value = endDate;
        }

        // ============ INITIALIZE DASHBOARD ============
        document.addEventListener('DOMContentLoaded', function () {
            initDashboard();
        });
    </script>
    <script>
        async function setSalesPersonDropdown() {
            const admin = await getLoggedAdmin();
            if (!admin) return;

            const select = document.getElementById('sales_person');

            select.innerHTML = `
            <option value="all">All Sales Persons</option>
        `;

            // Add current admin
            const option = document.createElement("option");
            option.value = admin.id;
            option.textContent = admin.firstname || admin.username || `User ${admin.id}`;
            option.selected = true;
            select.appendChild(option);

            // Also populate with other staff members from staffList if available
            if (staffList && staffList.length > 0) {
                staffList.forEach(staff => {
                    if (staff.id !== admin.id) {
                        const staffOption = document.createElement("option");
                        staffOption.value = staff.id;
                        const fullName = getStaffFullName(staff);
                        staffOption.textContent = fullName;
                        select.appendChild(staffOption);
                    }
                });
            }

            // Load initial dashboard data for the logged-in admin
            await loadDashboardData(admin.id);
        }

        async function loadDashboardData(userId) {
            if (!userId) {
                console.error("No user ID provided");
                return;
            }

            try {
                showLoader('Loading dashboard data...');

                // Get current date values from the form
                const date_from = document.getElementById('date_from').value;
                const date_to = document.getElementById('date_to').value;

                // Convert dates to proper format
                const formattedDateFrom = convertToDMY(date_from);
                const formattedDateTo = convertToDMY(date_to);

                // Set the sales person dropdown to the selected user
                const select = document.getElementById('sales_person');
                if (select) {
                    select.value = userId;
                }

                // Prepare form data with the selected user
                const formData = {
                    sales_person: userId,
                    date_from: formattedDateFrom,
                    date_to: formattedDateTo
                };

                // Use the existing loadKPIReport function to load data
                await loadKPIReport(formData);

                // Also load follow-ups and tasks for this user
                await loadTasksWithMainFilters();

                softAlert(`Dashboard loaded for selected user`, 'success');

            } catch (error) {
                console.error("Error loading dashboard data:", error);
                softAlert('Error loading dashboard data', 'error');
            } finally {
                hideLoader();
            }
        }

        // AUTO LOAD AFTER LOGIN
        document.addEventListener("DOMContentLoaded", () => {
            // Initialize the dashboard first
            initDashboard().then(() => {
                // Then set the sales person dropdown with logged-in admin
                setSalesPersonDropdown();
            });
        });

        // ON CHANGE - Update to use the existing dashboard loading system
        document.getElementById("sales_person").addEventListener("change", function () {
            if (this.value === "all") {
                // If "All Sales Persons" is selected, use the original report loading
                const formData = getFormData();
                loadKPIReport(formData);
            } else {
                // If a specific user is selected, use the new function
                loadDashboardData(this.value);
            }
        });
    </script>

</body>

</html>