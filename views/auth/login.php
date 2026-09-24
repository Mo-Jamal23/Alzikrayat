<div class="row justify-content-center">
    <div class="col-md-6 col-lg-5">
        <div class="eyebrow">Welcome Back 🥳</div>

        <h1 class="fw-bold mt-2">Sign in</h1>

        <?php if ($lastLogin): ?>
            <div class="alert alert-secondary small">
                Last login from this computer was:
                <?= e($lastLogin) ?>
            </div>
        <?php endif; ?>

        <form
            class="panel p-4 mt-4"
            method="post"
            action="<?= baseUrl('login') ?>"
        >
            <input
                type="hidden"
                name="csrf"
                value="<?= csrfToken() ?>"
            >

            <div class="mb-3">
                <label class="form-label">Email</label>

                <input
                    class="form-control"
                    type="email"
                    name="email"
                    required
                >
            </div>

            <div class="mb-3">
                <label class="form-label">Password</label>

                <div class="input-group">
                    <input
                        class="form-control"
                        type="password"
                        name="password"
                        id="loginPassword"
                        required
                    >

                    <button
                        type="button"
                        class="btn btn-outline-secondary"
                        id="toggleLoginPassword"
                    >
                        Show
                    </button>
                </div>
            </div>

            <button type="submit" class="btn btn-dark w-100">
                Sign in
            </button>

            <p class="small text-secondary mt-3 mb-0">
                New here?
                <a href="<?= baseUrl('register') ?>">
                    Create an account
                </a>
            </p>
        </form>
    </div>
</div>

<script>
    const toggleLoginPassword =
        document.getElementById('toggleLoginPassword');

    const loginPassword =
        document.getElementById('loginPassword');

    toggleLoginPassword.addEventListener('click', function () {
        if (loginPassword.type === 'password') {
            loginPassword.type = 'text';
            toggleLoginPassword.textContent = 'Hide';
        } else {
            loginPassword.type = 'password';
            toggleLoginPassword.textContent = 'Show';
        }
    });
</script>
