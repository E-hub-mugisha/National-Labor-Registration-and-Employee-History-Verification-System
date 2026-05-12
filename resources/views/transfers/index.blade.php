@extends('layouts.app')

@section('title', 'Transfer Requests')

@section('content')

<style>
    @import url('https://fonts.googleapis.com/css2?family=Outfit:wght@400;500;600;700;800&family=Inter:wght@300;400;500;600;700&display=swap');

    /* ──────────────────────────────────────────────────────────────────────────
   ROOT & CSS VARIABLES
   ────────────────────────────────────────────────────────────────────────── */

    :root {
        /* Color Palette */
        --color-primary: #3b82f6;
        /* Blue */
        --color-primary-dark: #1e40af;
        --color-primary-light: #dbeafe;

        --color-success: #10b981;
        /* Emerald */
        --color-success-dark: #059669;
        --color-success-light: #d1fae5;

        --color-danger: #ef4444;
        /* Red */
        --color-danger-dark: #dc2626;
        --color-danger-light: #fee2e2;

        --color-warning: #f59e0b;
        /* Amber */
        --color-warning-dark: #d97706;
        --color-warning-light: #fef3c7;

        --color-neutral-50: #f9fafb;
        --color-neutral-100: #f3f4f6;
        --color-neutral-200: #e5e7eb;
        --color-neutral-300: #d1d5db;
        --color-neutral-400: #9ca3af;
        --color-neutral-500: #6b7280;
        --color-neutral-600: #4b5563;
        --color-neutral-700: #374151;
        --color-neutral-800: #1f2937;
        --color-neutral-900: #111827;

        /* Typography */
        --font-display: 'Outfit', sans-serif;
        --font-body: 'Inter', sans-serif;

        /* Spacing */
        --spacing-xs: 0.25rem;
        --spacing-sm: 0.5rem;
        --spacing-md: 1rem;
        --spacing-lg: 1.5rem;
        --spacing-xl: 2rem;
        --spacing-2xl: 3rem;
        --spacing-3xl: 4rem;

        /* Border Radius */
        --radius-sm: 0.375rem;
        --radius-md: 0.5rem;
        --radius-lg: 0.75rem;
        --radius-xl: 1rem;
        --radius-2xl: 1.5rem;

        /* Shadows */
        --shadow-sm: 0 1px 2px 0 rgba(0, 0, 0, 0.05);
        --shadow-md: 0 4px 6px -1px rgba(0, 0, 0, 0.1), 0 2px 4px -1px rgba(0, 0, 0, 0.06);
        --shadow-lg: 0 10px 15px -3px rgba(0, 0, 0, 0.1), 0 4px 6px -2px rgba(0, 0, 0, 0.05);
        --shadow-xl: 0 20px 25px -5px rgba(0, 0, 0, 0.1), 0 10px 10px -5px rgba(0, 0, 0, 0.04);
        --shadow-2xl: 0 25px 50px -12px rgba(0, 0, 0, 0.25);

        /* Transitions */
        --transition-fast: 150ms cubic-bezier(0.4, 0, 0.2, 1);
        --transition-normal: 250ms cubic-bezier(0.4, 0, 0.2, 1);
        --transition-slow: 350ms cubic-bezier(0.4, 0, 0.2, 1);

        /* Z-index */
        --z-dropdown: 1000;
        --z-sticky: 1020;
        --z-fixed: 1030;
        --z-modal-backdrop: 1040;
        --z-modal: 1050;
        --z-popover: 1060;
        --z-tooltip: 1070;
    }

    /* Dark mode support */
    @media (prefers-color-scheme: dark) {
        :root {
            --color-neutral-50: #0f1419;
            --color-neutral-100: #1a202c;
            --color-neutral-200: #2d3748;
            --color-neutral-300: #4a5568;
            --color-neutral-400: #718096;
            --color-neutral-500: #a0aec0;
            --color-neutral-600: #cbd5e0;
            --color-neutral-700: #e2e8f0;
            --color-neutral-800: #edf2f7;
            --color-neutral-900: #f7fafc;
        }
    }

    /* ──────────────────────────────────────────────────────────────────────────
   GLOBAL STYLES
   ────────────────────────────────────────────────────────────────────────── */

    * {
        margin: 0;
        padding: 0;
        box-sizing: border-box;
    }

    html {
        scroll-behavior: smooth;
        -webkit-font-smoothing: antialiased;
        -moz-osx-font-smoothing: grayscale;
    }

    body {
        font-family: var(--font-body);
        font-size: 0.9375rem;
        line-height: 1.6;
        color: var(--color-neutral-700);
        background-color: var(--color-neutral-50);
        overflow-x: hidden;
    }

    /* ──────────────────────────────────────────────────────────────────────────
   TYPOGRAPHY
   ────────────────────────────────────────────────────────────────────────── */

    h1,
    h2,
    h3,
    h4,
    h5,
    h6 {
        font-family: var(--font-display);
        font-weight: 700;
        line-height: 1.2;
        letter-spacing: -0.02em;
        color: var(--color-neutral-900);
    }

    h1 {
        font-size: 2rem;
        font-weight: 800;
        letter-spacing: -0.03em;
        margin-bottom: var(--spacing-lg);
    }

    h2 {
        font-size: 1.5rem;
        font-weight: 700;
        margin-bottom: var(--spacing-md);
    }

    h3 {
        font-size: 1.25rem;
        font-weight: 600;
        margin-bottom: var(--spacing-sm);
    }

    p {
        margin-bottom: var(--spacing-md);
    }

    a {
        color: var(--color-primary);
        text-decoration: none;
        transition: color var(--transition-fast);
    }

    a:hover {
        color: var(--color-primary-dark);
        text-decoration: underline;
    }

    /* ──────────────────────────────────────────────────────────────────────────
   HEADER & NAVIGATION
   ────────────────────────────────────────────────────────────────────────── */

    .transfers-header {
        border-bottom: 1px solid var(--color-neutral-200);
        background: linear-gradient(135deg, #ffffff 0%, #f9fafb 100%);
        box-shadow: var(--shadow-sm);
    }

    .transfers-header__content {
        max-width: 80rem;
        margin: 0 auto;
        padding: var(--spacing-xl) var(--spacing-lg);
        display: flex;
        align-items: center;
        justify-content: space-between;
    }

    .transfers-header__title {
        margin-bottom: var(--spacing-sm);
    }

    .transfers-header__subtitle {
        font-size: 0.875rem;
        color: var(--color-neutral-500);
        font-weight: 500;
    }

    .transfers-header__employer {
        display: flex;
        align-items: center;
        gap: var(--spacing-md);
        background: linear-gradient(135deg, var(--color-neutral-100) 0%, var(--color-neutral-200) 100%);
        padding: var(--spacing-md) var(--spacing-lg);
        border-radius: var(--radius-lg);
        border: 1px solid var(--color-neutral-200);
        transition: all var(--transition-normal);
    }

    .transfers-header__employer:hover {
        border-color: var(--color-neutral-300);
        box-shadow: var(--shadow-md);
        transform: translateY(-2px);
    }

    .transfers-header__employer-icon {
        width: 1.25rem;
        height: 1.25rem;
        color: var(--color-neutral-500);
    }

    .transfers-header__employer-name {
        font-size: 0.875rem;
        font-weight: 600;
        color: var(--color-neutral-700);
    }

    /* ──────────────────────────────────────────────────────────────────────────
   TABS & NAVIGATION
   ────────────────────────────────────────────────────────────────────────── */

    .tabs-container {
        display: flex;
        gap: var(--spacing-xs);
        padding: var(--spacing-sm);
        background: white;
        border: 1px solid var(--color-neutral-200);
        border-radius: var(--radius-lg);
        margin-bottom: var(--spacing-xl);
        box-shadow: var(--shadow-sm);
    }

    .tab-btn {
        flex: 1;
        padding: var(--spacing-md) var(--spacing-lg);
        font-size: 0.875rem;
        font-weight: 600;
        border: none;
        background: transparent;
        color: var(--color-neutral-500);
        border-radius: var(--radius-md);
        cursor: pointer;
        transition: all var(--transition-normal);
        display: flex;
        align-items: center;
        justify-content: center;
        gap: var(--spacing-sm);
        position: relative;
        overflow: hidden;
    }

    .tab-btn::before {
        content: '';
        position: absolute;
        top: 0;
        left: -100%;
        width: 100%;
        height: 100%;
        background: linear-gradient(90deg, transparent, rgba(255, 255, 255, 0.3), transparent);
        transition: left var(--transition-normal);
    }

    .tab-btn:hover {
        color: var(--color-neutral-700);
        background: var(--color-neutral-100);
    }

    .tab-btn.active {
        background: white;
        color: var(--color-neutral-900);
        box-shadow: var(--shadow-sm);
        font-weight: 700;
    }

    .tab-badge {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        margin-left: var(--spacing-sm);
        padding: 0.25rem var(--spacing-md);
        border-radius: 9999px;
        font-size: 0.75rem;
        font-weight: 700;
        min-width: 1.75rem;
        height: 1.5rem;
    }

    .tab-badge--primary {
        background-color: #dbeafe;
        color: #0c4a6e;
    }

    .tab-badge--success {
        background-color: #d1fae5;
        color: #065f46;
    }

    /* ──────────────────────────────────────────────────────────────────────────
   TRANSFER CARDS
   ────────────────────────────────────────────────────────────────────────── */

    .transfers-list {
        display: grid;
        gap: var(--spacing-lg);
    }

    .transfer-card {
        background: white;
        border: 1px solid var(--color-neutral-200);
        border-radius: var(--radius-xl);
        overflow: hidden;
        transition: all var(--transition-normal);
        animation: slideInUp 0.4s ease-out;
    }

    .transfer-card:hover {
        border-color: var(--color-neutral-300);
        box-shadow: var(--shadow-lg);
        transform: translateY(-4px);
    }

    @keyframes slideInUp {
        from {
            opacity: 0;
            transform: translateY(20px);
        }

        to {
            opacity: 1;
            transform: translateY(0);
        }
    }

    .transfer-card__header {
        display: flex;
        align-items: flex-start;
        justify-content: space-between;
        padding: var(--spacing-xl) var(--spacing-lg);
        border-bottom: 1px solid var(--color-neutral-100);
        background: linear-gradient(135deg, #fafbfc 0%, #f3f4f6 100%);
    }

    .transfer-card__title-group {
        display: flex;
        align-items: baseline;
        gap: var(--spacing-md);
        flex-wrap: wrap;
    }

    .transfer-card__title {
        font-size: 1.125rem;
        font-weight: 700;
        color: var(--color-neutral-900);
        margin: 0;
    }

    .transfer-card__subtitle {
        font-size: 0.875rem;
        color: var(--color-neutral-500);
        margin-top: var(--spacing-sm);
        font-weight: 500;
    }

    .transfer-card__subtitle strong {
        color: var(--color-neutral-700);
        font-weight: 600;
    }

    .transfer-card__meta {
        text-align: right;
    }

    .transfer-card__meta-label {
        font-size: 0.75rem;
        color: var(--color-neutral-500);
        text-transform: uppercase;
        letter-spacing: 0.05em;
        font-weight: 600;
        margin-bottom: var(--spacing-xs);
    }

    .transfer-card__meta-value {
        font-size: 0.875rem;
        font-weight: 700;
        color: var(--color-neutral-700);
    }

    .transfer-card__body {
        padding: var(--spacing-xl) var(--spacing-lg);
    }

    .transfer-card__details {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
        gap: var(--spacing-lg);
    }

    .transfer-card__detail {
        display: flex;
        flex-direction: column;
    }

    .transfer-card__detail-label {
        font-size: 0.75rem;
        font-weight: 700;
        color: var(--color-neutral-500);
        text-transform: uppercase;
        letter-spacing: 0.05em;
        margin-bottom: var(--spacing-sm);
    }

    .transfer-card__detail-value {
        font-size: 0.9375rem;
        font-weight: 700;
        color: var(--color-neutral-900);
    }

    .transfer-card__message {
        margin-top: var(--spacing-lg);
        padding: var(--spacing-md);
        background: linear-gradient(135deg, #eff6ff 0%, #dbeafe 100%);
        border-left: 4px solid var(--color-primary);
        border-radius: var(--radius-md);
    }

    .transfer-card__message-text {
        font-size: 0.875rem;
        color: #0c4a6e;
        margin: 0;
    }

    .transfer-card__message-label {
        font-weight: 700;
        margin-right: var(--spacing-xs);
    }

    .transfer-card__footer {
        padding: var(--spacing-lg);
        border-top: 1px solid var(--color-neutral-100);
        background: var(--color-neutral-50);
        display: flex;
        align-items: center;
        justify-content: space-between;
    }

    .transfer-card__footer--pending {
        flex-wrap: wrap;
        gap: var(--spacing-md);
    }

    /* ──────────────────────────────────────────────────────────────────────────
   STATUS BADGES
   ────────────────────────────────────────────────────────────────────────── */

    .status-badge {
        display: inline-flex;
        align-items: center;
        padding: 0.375rem var(--spacing-md);
        border-radius: 9999px;
        font-size: 0.75rem;
        font-weight: 700;
        text-transform: uppercase;
        letter-spacing: 0.05em;
    }

    .status-badge--pending {
        background-color: #fef3c7;
        color: #78350f;
    }

    .status-badge--approved {
        background-color: #d1fae5;
        color: #065f46;
    }

    .status-badge--rejected {
        background-color: #fee2e2;
        color: #7f1d1d;
    }

    .status-badge--cancelled {
        background-color: #e5e7eb;
        color: #374151;
    }

    /* ──────────────────────────────────────────────────────────────────────────
   BUTTONS & ACTIONS
   ────────────────────────────────────────────────────────────────────────── */

    .btn {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        gap: var(--spacing-sm);
        padding: 0.625rem var(--spacing-lg);
        font-family: var(--font-display);
        font-size: 0.875rem;
        font-weight: 600;
        border: none;
        border-radius: var(--radius-lg);
        cursor: pointer;
        transition: all var(--transition-normal);
        position: relative;
        overflow: hidden;
        white-space: nowrap;
    }

    .btn::before {
        content: '';
        position: absolute;
        top: 50%;
        left: 50%;
        width: 0;
        height: 0;
        border-radius: 50%;
        background: rgba(255, 255, 255, 0.5);
        transform: translate(-50%, -50%);
        transition: width var(--transition-fast), height var(--transition-fast);
    }

    .btn:active::before {
        width: 300px;
        height: 300px;
    }

    .btn--primary {
        background: linear-gradient(135deg, var(--color-primary) 0%, #1e40af 100%);
        color: white;
        box-shadow: var(--shadow-md);
    }

    .btn--primary:hover {
        background: linear-gradient(135deg, #1e40af 0%, #1e3a8a 100%);
        box-shadow: var(--shadow-lg);
        transform: translateY(-2px);
    }

    .btn--primary:active {
        transform: translateY(0);
    }

    .btn--success {
        background: linear-gradient(135deg, var(--color-success) 0%, #059669 100%);
        color: white;
        box-shadow: var(--shadow-md);
    }

    .btn--success:hover {
        background: linear-gradient(135deg, #059669 0%, #047857 100%);
        box-shadow: var(--shadow-lg);
        transform: translateY(-2px);
    }

    .btn--danger {
        background: linear-gradient(135deg, var(--color-danger) 0%, #dc2626 100%);
        color: white;
        box-shadow: var(--shadow-md);
    }

    .btn--danger:hover {
        background: linear-gradient(135deg, #dc2626 0%, #b91c1c 100%);
        box-shadow: var(--shadow-lg);
        transform: translateY(-2px);
    }

    .btn--secondary {
        background: white;
        color: var(--color-neutral-700);
        border: 1px solid var(--color-neutral-300);
    }

    .btn--secondary:hover {
        background: var(--color-neutral-100);
        border-color: var(--color-neutral-400);
    }

    .btn-group {
        display: flex;
        gap: var(--spacing-md);
        flex-wrap: wrap;
    }

    .action-link {
        display: inline-flex;
        align-items: center;
        gap: var(--spacing-sm);
        color: var(--color-primary);
        font-weight: 600;
        font-size: 0.875rem;
        transition: all var(--transition-normal);
        text-decoration: none;
    }

    .action-link:hover {
        color: var(--color-primary-dark);
        transform: translateX(4px);
    }

    /* ──────────────────────────────────────────────────────────────────────────
   MODALS
   ────────────────────────────────────────────────────────────────────────── */

    .modal {
        display: none;
        position: fixed;
        inset: 0;
        z-index: var(--z-modal);
        background-color: rgba(0, 0, 0, 0.5);
        backdrop-filter: blur(4px);
        -webkit-backdrop-filter: blur(4px);
        animation: fadeIn var(--transition-normal);
    }

    .modal.active {
        display: flex;
        align-items: center;
        justify-content: center;
    }

    @keyframes fadeIn {
        from {
            opacity: 0;
        }

        to {
            opacity: 1;
        }
    }

    .modal__content {
        background: white;
        border-radius: var(--radius-xl);
        padding: var(--spacing-xl);
        max-width: 28rem;
        width: 100%;
        box-shadow: var(--shadow-2xl);
        animation: slideUp var(--transition-normal);
    }

    @keyframes slideUp {
        from {
            opacity: 0;
            transform: translateY(20px);
        }

        to {
            opacity: 1;
            transform: translateY(0);
        }
    }

    .modal__header {
        margin-bottom: var(--spacing-lg);
    }

    .modal__title {
        font-size: 1.125rem;
        font-weight: 700;
        color: var(--color-neutral-900);
        margin-bottom: var(--spacing-md);
    }

    .modal__description {
        font-size: 0.875rem;
        color: var(--color-neutral-600);
    }

    .modal__body {
        margin-bottom: var(--spacing-lg);
    }

    .modal__textarea {
        width: 100%;
        padding: var(--spacing-md);
        border: 1px solid var(--color-neutral-300);
        border-radius: var(--radius-lg);
        font-family: var(--font-body);
        font-size: 0.875rem;
        resize: vertical;
        transition: border-color var(--transition-normal), box-shadow var(--transition-normal);
    }

    .modal__textarea:focus {
        outline: none;
        border-color: var(--color-primary);
        box-shadow: 0 0 0 3px rgba(59, 130, 246, 0.1);
    }

    .modal__textarea::placeholder {
        color: var(--color-neutral-400);
    }

    .modal__footer {
        display: flex;
        gap: var(--spacing-md);
    }

    /* ──────────────────────────────────────────────────────────────────────────
   EMPTY STATES
   ────────────────────────────────────────────────────────────────────────── */

    .empty-state {
        padding: 3rem var(--spacing-lg);
        text-align: center;
        border: 2px dashed var(--color-neutral-300);
        border-radius: var(--radius-xl);
        background: var(--color-neutral-50);
    }

    .empty-state__icon {
        width: 3rem;
        height: 3rem;
        margin: 0 auto var(--spacing-lg);
        color: var(--color-neutral-400);
    }

    .empty-state__title {
        font-size: 1.125rem;
        font-weight: 700;
        color: var(--color-neutral-900);
        margin-bottom: var(--spacing-sm);
    }

    .empty-state__description {
        font-size: 0.875rem;
        color: var(--color-neutral-600);
    }

    /* ──────────────────────────────────────────────────────────────────────────
   ANIMATIONS
   ────────────────────────────────────────────────────────────────────────── */

    @keyframes spin {
        from {
            transform: rotate(0deg);
        }

        to {
            transform: rotate(360deg);
        }
    }

    .animate-spin {
        animation: spin 1s linear infinite;
    }

    @keyframes pulse {

        0%,
        100% {
            opacity: 1;
        }

        50% {
            opacity: 0.5;
        }
    }

    .animate-pulse {
        animation: pulse 2s cubic-bezier(0.4, 0, 0.6, 1) infinite;
    }

    @keyframes shimmer {
        0% {
            background-position: -1000px 0;
        }

        100% {
            background-position: 1000px 0;
        }
    }

    .animate-shimmer {
        background: linear-gradient(90deg,
                transparent,
                rgba(255, 255, 255, 0.3),
                transparent);
        background-size: 1000px 100%;
        animation: shimmer 2s infinite;
    }

    /* ──────────────────────────────────────────────────────────────────────────
   PAGINATION
   ────────────────────────────────────────────────────────────────────────── */

    .pagination {
        display: flex;
        gap: var(--spacing-sm);
        justify-content: center;
        margin-top: var(--spacing-2xl);
        flex-wrap: wrap;
    }

    .pagination__item {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        width: 2.5rem;
        height: 2.5rem;
        border: 1px solid var(--color-neutral-300);
        border-radius: var(--radius-md);
        background: white;
        color: var(--color-neutral-700);
        text-decoration: none;
        font-weight: 500;
        transition: all var(--transition-normal);
    }

    .pagination__item:hover {
        border-color: var(--color-primary);
        background: var(--color-primary-light);
        color: var(--color-primary-dark);
    }

    .pagination__item.active {
        background: var(--color-primary);
        border-color: var(--color-primary);
        color: white;
    }

    /* ──────────────────────────────────────────────────────────────────────────
   RESPONSIVE DESIGN
   ────────────────────────────────────────────────────────────────────────── */

    @media (max-width: 768px) {
        :root {
            font-size: 15px;
        }

        h1 {
            font-size: 1.5rem;
        }

        .transfers-header__content {
            flex-direction: column;
            align-items: flex-start;
            gap: var(--spacing-lg);
        }

        .transfer-card__header {
            flex-direction: column;
            gap: var(--spacing-lg);
        }

        .transfer-card__title-group {
            flex-direction: column;
        }

        .transfer-card__footer {
            flex-direction: column;
            align-items: flex-start;
        }

        .transfer-card__details {
            grid-template-columns: 1fr;
        }

        .btn-group {
            width: 100%;
            flex-direction: column;
        }

        .btn {
            width: 100%;
        }

        .modal__content {
            max-width: calc(100% - var(--spacing-2xl));
        }
    }

    @media (max-width: 480px) {
        .tabs-container {
            flex-direction: column;
        }

        .tab-btn {
            padding: var(--spacing-md);
            font-size: 0.8125rem;
        }

        .tab-badge {
            position: absolute;
            top: 0;
            right: 0;
            transform: translate(50%, -50%);
        }

        .transfer-card__title {
            font-size: 1rem;
        }

        .transfer-card__meta {
            text-align: left;
            margin-top: var(--spacing-md);
        }

        .status-badge {
            font-size: 0.7rem;
            padding: 0.25rem var(--spacing-sm);
        }
    }

    /* ──────────────────────────────────────────────────────────────────────────
   UTILITY CLASSES
   ────────────────────────────────────────────────────────────────────────── */

    .hidden {
        display: none !important;
    }

    .sr-only {
        position: absolute;
        width: 1px;
        height: 1px;
        padding: 0;
        margin: -1px;
        overflow: hidden;
        clip: rect(0, 0, 0, 0);
        white-space: nowrap;
        border-width: 0;
    }

    .no-select {
        user-select: none;
        -webkit-user-select: none;
        -moz-user-select: none;
        -ms-user-select: none;
    }

    .truncate {
        overflow: hidden;
        text-overflow: ellipsis;
        white-space: nowrap;
    }

    .line-clamp-2 {
        display: -webkit-box;
        -webkit-line-clamp: 2;
        -webkit-box-orient: vertical;
        overflow: hidden;
    }

    /* ──────────────────────────────────────────────────────────────────────────
   FOCUS STATES & ACCESSIBILITY
   ────────────────────────────────────────────────────────────────────────── */

    :focus-visible {
        outline: 2px solid var(--color-primary);
        outline-offset: 2px;
    }

    input:focus-visible,
    textarea:focus-visible,
    select:focus-visible {
        outline: 2px solid var(--color-primary);
        outline-offset: 0;
    }

    @media (prefers-reduced-motion: reduce) {

        *,
        *::before,
        *::after {
            animation-duration: 0.01ms !important;
            animation-iteration-count: 1 !important;
            transition-duration: 0.01ms !important;
            scroll-behavior: auto !important;
        }
    }

    /* ──────────────────────────────────────────────────────────────────────────
   PRINT STYLES
   ────────────────────────────────────────────────────────────────────────── */

    @media print {

        .modal,
        .btn-group,
        .pagination {
            display: none;
        }

        .transfer-card {
            page-break-inside: avoid;
            box-shadow: none;
            border: 1px solid var(--color-neutral-300);
        }
    }
</style>

<div class="min-h-screen bg-gradient-to-br from-slate-50 via-slate-50 to-slate-100">

    <!-- Header -->
    <header class="transfers-header">
        <div class="transfers-header__content">
            <div>
                <h1 class="transfers-header__title">Transfer Requests</h1>
                <p class="transfers-header__subtitle">Manage incoming and outgoing employee transfer requests</p>
            </div>
            <div class="transfers-header__employer">
                <svg class="transfers-header__employer-icon" fill="currentColor" viewBox="0 0 20 20">
                    <path d="M13 6a3 3 0 11-6 0 3 3 0 016 0zM18 8a2 2 0 11-4 0 2 2 0 014 0zm-6 8a2 2 0 11-4 0 2 2 0 014 0zM9 17a6 6 0 1012 0 6 6 0 00-12 0z"></path>
                </svg>
                <span class="transfers-header__employer-name">{{ $employer->name }}</span>
            </div>
        </div>
    </header>

    <main class="mx-auto max-w-7xl px-4 py-8 sm:px-6 lg:px-8">

        <!-- Tabs Navigation -->
        <div class="tabs-container">
            <button class="tab-btn active" data-tab="incoming">
                <svg class="h-4 w-4" fill="currentColor" viewBox="0 0 20 20">
                    <path d="M2 11a1 1 0 011-1h2.101a7.002 7.002 0 0111.601-2.566 1 1 0 11-1.414 1.414A5.002 5.002 0 005.999 10H8a1 1 0 110 2H2a1 1 0 01-1-1z"></path>
                </svg>
                <span>Incoming</span>
                <span class="tab-badge tab-badge--primary">{{ $incoming->total() }}</span>
            </button>
            <button class="tab-btn" data-tab="outgoing">
                <svg class="h-4 w-4" fill="currentColor" viewBox="0 0 20 20">
                    <path d="M18 9a1 1 0 01-1 1h-2.101a7.002 7.002 0 01-11.601 2.566 1 1 0 111.414-1.414A5.002 5.002 0 0114.001 10H12a1 1 0 110-2h6a1 1 0 011 1z"></path>
                </svg>
                <span>Outgoing</span>
                <span class="tab-badge tab-badge--success">{{ $outgoing->total() }}</span>
            </button>
        </div>

        <!-- Incoming Requests Tab -->
        <div id="incoming-tab" class="tab-content">
            @if($incoming->count() > 0)
            <div class="transfers-list">
                @foreach($incoming as $request)
                <article class="transfer-card">
                    <!-- Card Header -->
                    <div class="transfer-card__header">
                        <div class="flex-1">
                            <div class="transfer-card__title-group">
                                <h3 class="transfer-card__title">
                                    {{ $request->employee->full_name }}
                                </h3>
                                <span class="status-badge status-badge--{{ $request->status }}">
                                    {{ $request->status }}
                                </span>
                            </div>
                            <p class="transfer-card__subtitle">
                                Transfer from <strong>{{ $request->requestingEmployer->name }}</strong>
                            </p>
                        </div>
                        <div class="transfer-card__meta">
                            <p class="transfer-card__meta-label">Requested</p>
                            <p class="transfer-card__meta-value">{{ $request->created_at->format('M d, Y') }}</p>
                        </div>
                    </div>

                    <!-- Card Body -->
                    <div class="transfer-card__body">
                        <div class="transfer-card__details">
                            <div class="transfer-card__detail">
                                <span class="transfer-card__detail-label">Position Requested</span>
                                <span class="transfer-card__detail-value">{{ $request->requested_position }}</span>
                            </div>
                            <div class="transfer-card__detail">
                                <span class="transfer-card__detail-label">Current Position</span>
                                <span class="transfer-card__detail-value">
                                    {{ $request->employee->employmentRecord?->position ?? 'N/A' }}
                                </span>
                            </div>
                        </div>

                        @if($request->message)
                        <div class="transfer-card__message">
                            <p class="transfer-card__message-text">
                                <span class="transfer-card__message-label">Message:</span>{{ $request->message }}
                            </p>
                        </div>
                        @endif
                    </div>

                    <!-- Card Footer / Actions -->
                    @if($request->status === 'pending')
                    <div class="transfer-card__footer transfer-card__footer--pending">
                        <a href="{{ route('transfers.show', $request) }}" class="action-link">
                            <span>Review Details</span>
                            <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                            </svg>
                        </a>
                        <div class="btn-group">
                            <button type="button" class="btn btn--secondary reject-btn" data-request-id="{{ $request->id }}" data-action="{{ route('transfers.reject', $request) }}">
                                Reject
                            </button>
                            <a href="{{ route('transfers.show', $request) }}" class="btn btn--success">
                                Review & Approve
                            </a>
                        </div>
                    </div>
                    @else
                    <div class="transfer-card__footer">
                        <div>
                            <p class="transfer-card__meta-label">
                                {{ ucfirst($request->status) }} on {{ $request->responded_at?->format('M d, Y') }}
                            </p>
                            @if($request->response_note)
                            <p style="margin-top: var(--spacing-md); color: var(--color-neutral-700); font-size: 0.875rem;">
                                {{ $request->response_note }}
                            </p>
                            @endif
                        </div>
                    </div>
                    @endif
                </article>
                @endforeach
            </div>

            <!-- Pagination -->
            <nav class="pagination" role="navigation">
                {{ $incoming->links() }}
            </nav>
            @else
            <div class="empty-state">
                <svg class="empty-state__icon" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0h-2.586a1 1 0 00-.707.293l-2.414 2.414a1 1 0 01-.707.293h-3.172a1 1 0 01-.707-.293l-2.414-2.414A1 1 0 006.586 13H4"></path>
                </svg>
                <h3 class="empty-state__title">No incoming requests</h3>
                <p class="empty-state__description">You haven't received any transfer requests yet.</p>
            </div>
            @endif
        </div>

        <!-- Outgoing Requests Tab -->
        <div id="outgoing-tab" class="hidden tab-content">
            @if($outgoing->count() > 0)
            <div class="transfers-list">
                @foreach($outgoing as $request)
                <article class="transfer-card">
                    <!-- Card Header -->
                    <div class="transfer-card__header">
                        <div class="flex-1">
                            <div class="transfer-card__title-group">
                                <h3 class="transfer-card__title">
                                    {{ $request->employee->full_name }}
                                </h3>
                                <span class="status-badge status-badge--{{ $request->status }}">
                                    {{ $request->status }}
                                </span>
                            </div>
                            <p class="transfer-card__subtitle">
                                Transfer to <strong>{{ $request->currentEmployer->name }}</strong>
                            </p>
                        </div>
                        <div class="transfer-card__meta">
                            <p class="transfer-card__meta-label">Requested</p>
                            <p class="transfer-card__meta-value">{{ $request->created_at->format('M d, Y') }}</p>
                        </div>
                    </div>

                    <!-- Card Body -->
                    <div class="transfer-card__body">
                        <div class="transfer-card__details">
                            <div class="transfer-card__detail">
                                <span class="transfer-card__detail-label">Position Requested</span>
                                <span class="transfer-card__detail-value">{{ $request->requested_position }}</span>
                            </div>
                            <div class="transfer-card__detail">
                                <span class="transfer-card__detail-label">Current Position</span>
                                <span class="transfer-card__detail-value">
                                    {{ $request->employee->employmentRecord?->position ?? 'N/A' }}
                                </span>
                            </div>
                        </div>

                        @if($request->message)
                        <div class="transfer-card__message">
                            <p class="transfer-card__message-text">
                                <span class="transfer-card__message-label">Message:</span>{{ $request->message }}
                            </p>
                        </div>
                        @endif
                    </div>

                    <!-- Card Footer / Status -->
                    <div class="transfer-card__footer">
                        @if($request->status === 'pending')
                        <div style="width: 100%; display: flex; align-items: center; justify-content: space-between;">
                            <p style="font-size: 0.875rem; font-weight: 600; color: var(--color-neutral-700); display: flex; align-items: center; gap: var(--spacing-sm);">
                                <svg class="animate-spin h-4 w-4" style="color: var(--color-warning);" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                </svg>
                                Awaiting response from {{ $request->currentEmployer->name }}
                            </p>
                            <button type="button" class="cancel-btn" style="color: var(--color-danger); font-size: 0.875rem; font-weight: 600; cursor: pointer; transition: color var(--transition-normal);" data-request-id="{{ $request->id }}" data-action="{{ route('transfers.cancel', $request) }}">
                                Cancel Request
                            </button>
                        </div>
                        @else
                        <div>
                            <p class="transfer-card__meta-label">
                                {{ ucfirst($request->status) }} on {{ $request->responded_at?->format('M d, Y') }}
                            </p>
                            @if($request->response_note)
                            <p style="margin-top: var(--spacing-md); color: var(--color-neutral-700); font-size: 0.875rem;">
                                {{ $request->response_note }}
                            </p>
                            @endif
                        </div>
                        @endif
                    </div>
                </article>
                @endforeach
            </div>

            <!-- Pagination -->
            <nav class="pagination" role="navigation">
                {{ $outgoing->links() }}
            </nav>
            @else
            <div class="empty-state">
                <svg class="empty-state__icon" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 19l9 2-9-18-9 18 9-2zm0 0v-8"></path>
                </svg>
                <h3 class="empty-state__title">No outgoing requests</h3>
                <p class="empty-state__description">You haven't sent any transfer requests yet.</p>
            </div>
            @endif
        </div>
    </main>
</div>

<!-- Reject Modal -->
<div id="reject-modal" class="modal">
    <div class="modal__content">
        <div class="modal__header">
            <h3 class="modal__title">Reject Transfer Request</h3>
            <p class="modal__description">Please provide a reason for rejecting this transfer request.</p>
        </div>

        <form id="reject-form" method="POST" class="modal__body">
            @csrf
            <textarea name="response_note" rows="4" placeholder="Reason for rejection..." class="modal__textarea" required></textarea>
        </form>

        <div class="modal__footer">
            <button type="button" class="btn btn--secondary" onclick="closeRejectModal()" style="flex: 1;">
                Cancel
            </button>
            <button type="submit" form="reject-form" class="btn btn--danger" style="flex: 1;">
                Reject
            </button>
        </div>
    </div>
</div>

<!-- Cancel Modal -->
<div id="cancel-modal" class="modal">
    <div class="modal__content">
        <div class="modal__header">
            <h3 class="modal__title">Cancel Transfer Request</h3>
            <p class="modal__description">Are you sure you want to cancel this transfer request? This action cannot be undone.</p>
        </div>

        <div class="modal__footer">
            <button type="button" class="btn btn--secondary" onclick="closeCancelModal()" style="flex: 1;">
                Keep Request
            </button>
            <form id="cancel-form" method="POST" style="flex: 1;">
                @csrf
                <button type="submit" class="btn btn--danger" style="width: 100%;">
                    Cancel Request
                </button>
            </form>
        </div>
    </div>
</div>

<script>
    // Tab switching with smooth animation
    document.querySelectorAll('.tab-btn').forEach(btn => {
        btn.addEventListener('click', function() {
            const tabName = this.dataset.tab;

            // Update active tab button
            document.querySelectorAll('.tab-btn').forEach(b => {
                b.classList.remove('active');
            });
            this.classList.add('active');

            // Update visible tab content
            document.querySelectorAll('.tab-content').forEach(tab => {
                tab.classList.add('hidden');
            });
            document.getElementById(tabName + '-tab').classList.remove('hidden');
        });
    });

    // Reject modal handling
    document.querySelectorAll('.reject-btn').forEach(btn => {
        btn.addEventListener('click', function(e) {
            e.preventDefault();
            const modal = document.getElementById('reject-modal');
            const rejectForm = document.getElementById('reject-form');
            const action = this.dataset.action;

            rejectForm.action = action;
            modal.classList.add('active');
        });
    });

    function closeRejectModal() {
        document.getElementById('reject-modal').classList.remove('active');
    }

    // Cancel modal handling
    document.querySelectorAll('.cancel-btn').forEach(btn => {
        btn.addEventListener('click', function(e) {
            e.preventDefault();
            const modal = document.getElementById('cancel-modal');
            const cancelForm = document.getElementById('cancel-form');
            const action = this.dataset.action;

            cancelForm.action = action;
            modal.classList.add('active');
        });
    });

    function closeCancelModal() {
        document.getElementById('cancel-modal').classList.remove('active');
    }

    // Close modals on escape key or backdrop click
    document.addEventListener('keydown', function(e) {
        if (e.key === 'Escape') {
            closeRejectModal();
            closeCancelModal();
        }
    });

    // Close modals on backdrop click
    document.querySelectorAll('.modal').forEach(modal => {
        modal.addEventListener('click', function(e) {
            if (e.target === this) {
                this.classList.remove('active');
            }
        });
    });
</script>
@endsection