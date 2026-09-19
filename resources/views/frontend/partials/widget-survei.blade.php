{{-- Letakkan di bagian paling atas atau bawah file widget --}}
<style>
    .widget-survei-card {
        max-width: 480px;
        margin: 1.5rem auto;
        padding: 1.25rem 1.5rem;
        border-radius: 12px;
        background: #ffffff;
        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.05);
        border: 1px solid #e2e8f0;
    }

    .widget-survei-title {
        font-size: 1.1rem;
        font-weight: 600;
        margin-bottom: 0.25rem;
        color: #1e293b;
    }

    .widget-survei-desc {
        font-size: 0.85rem;
        color: #64748b;
        margin-bottom: 1rem;
    }

    .star-rating-wrapper {
        display: flex;
        justify-content: center;
        gap: 0.5rem;
        margin-bottom: 1rem;
    }

    .star-rating-wrapper svg,
    .star-rating-wrapper label {
        width: 28px;
        height: 28px;
        cursor: pointer;
        transition: transform 0.15s ease;
    }

    .star-rating-wrapper label:hover {
        transform: scale(1.15);
    }

    .widget-survei-textarea {
        width: 100%;
        padding: 0.5rem 0.75rem;
        font-size: 0.875rem;
        border-radius: 6px;
        border: 1px solid #cbd5e1;
        margin-bottom: 0.75rem;
        resize: none;
    }

    .widget-survei-btn {
        width: 100%;
        padding: 0.5rem 1rem;
        font-size: 0.875rem;
        font-weight: 500;
        border-radius: 6px;
        background-color: #2563eb;
        color: #ffffff;
        border: none;
        transition: background 0.2s ease;
    }

    .widget-survei-btn:hover {
        background-color: #1d4ed8;
    }
</style>
