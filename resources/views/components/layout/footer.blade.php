<footer class="footer">

    <div class="container footer__inner">

        <div class="split">

            <a
                href="{{ route('welcome') }}"
                class="footer__brand">

                <x-ui.icon name="network" />

                {{ config('app.name') }}

            </a>

            <span class="text-muted text-xs">
                Projeto acadêmico &bull; {{ date('Y') }}
            </span>

        </div>

        <p class="footer__description">
            Representação de Interações Medicamentosas
            Utilizando Modelagem em Grafos
        </p>

        <p class="footer__disclaimer">
            As informações apresentadas neste sistema possuem
            caráter educacional e não substituem avaliação
            ou orientação de profissionais de saúde.
        </p>

    </div>

</footer>
