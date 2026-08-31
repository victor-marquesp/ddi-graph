<x-layouts.app>

    <x-slot:title>Login Necessário</x-slot:title>

    <div class="container min-vh-100 d-flex align-items-center justify-content-center py-5">
        <div class="card shadow-lg border-0 text-center" style="max-width: 600px;">
            <div class="card-body p-5">

                <div class="mb-4">
                    <div class="d-inline-flex align-items-center justify-content-center
                                bg-warning-subtle text-warning rounded-circle p-4">
                        <i class="bi bi-shield-lock-fill fs-1"></i>
                    </div>
                </div>

                <span class="badge text-bg-warning mb-3">
                    Access restricted
                </span>

                <h1 class="display-6 fw-bold mb-3">
                    Login necessário
                </h1>

                <p class="lead text-body-secondary mb-2">
                    Desculpe, esta página é apenas para administradores.
                </p>

                <p class="text-body-secondary mb-4">
                    Você precisa estar autenticado com uma conta de administrador
                    para acessar este conteúdo.
                </p>

                <div class="d-grid gap-2 d-sm-flex justify-content-sm-center">
                    <a href="{{ route('auth.login.form') }}"
                    class="btn btn-primary btn-lg px-4 gap-3">
                        <i class="bi bi-box-arrow-in-right me-2"></i>
                        Login
                    </a>

                    <a href="{{ route('welcome') }}"
                    class="btn btn-outline-secondary btn-lg px-4">
                        Voltar
                    </a>
                </div>

            </div>

            <div class="card-footer bg-body-tertiary border-0 py-3">
                <small class="text-body-secondary">
                    Acesso restrito a usuários autorizados.
                </small>
            </div>
        </div>
    </div>

</x-layouts.app>