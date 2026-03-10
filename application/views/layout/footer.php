
    <script>
        // Auto hide toasts after 3 seconds
        setTimeout(() => {
            const toasts = document.querySelectorAll('[role="alert"]');
            toasts.forEach(t => t.remove());
        }, 5000);
    </script>
</body>
</html>
