@if ($errors->any())
    <div id="alert-container">
        @foreach ($errors->all() as $error)
            <div class="alert alert-danger">
                {{ $error }}
            </div>
        @endforeach
    </div>
@endif

@if (session()->has('message_success'))
    <div id="alert-container" class="alert alert-success" role="alert">
        {{ session('message_success') }}
    </div>
@endif

@if (session()->has('message_error'))
    <div id="alert-container" class="alert alert-danger" role="alert">
        {{ session('message_error') }}
    </div>
@endif

<style>
    #alert-container {
        position: fixed;
        bottom: 1rem;
        right: 1rem;
        z-index: 1000;
    }

    .alert {
        margin-bottom: 1rem;
        padding: 1rem;
        border-radius: 8px;
        box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        animation: slide-in 0.5s ease, fade-out 0.5s ease 4s forwards;
    }

    /* Slide-in animation */
    @keyframes slide-in {
        from {
            opacity: 0;
            transform: translateX(100%);
        }

        to {
            opacity: 1;
            transform: translateX(0);
        }
    }

    /* Fade-out animation */
    @keyframes fade-out {
        to {
            opacity: 0;
            transform: translateX(100%);
        }
    }
</style>

<script>
    // Auto-hide alert after 4 seconds
    document.addEventListener('DOMContentLoaded', () => {
        const alert = document.getElementById('alert-container');
        if (alert) {
            setTimeout(() => {
                alert.style.animation = 'fade-out 0.5s ease forwards';
                setTimeout(() => alert.remove(), 500); // Ensure element is removed after fade-out
            }, 4000);
        }
    });
</script>
