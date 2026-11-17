<dialog
    id="disclaimer-modal"
    class="modal modal--lg"
    data-disclaimer
    data-disclaimer-duration="10"
    data-disclaimer-version="1"
    aria-labelledby="disclaimer-title">

    <div class="disclaimer">

        <div class="disclaimer__icon">
            <x-ui.icon name="info" size="xl" />
        </div>

        <h2 id="disclaimer-title">
            Aviso sobre a finalidade do sistema
        </h2>

        <p>
            Este sistema foi desenvolvido como parte do Trabalho
            de Conclusão de Curso (TCC) intitulado
            <strong>
                Representação de Interações Medicamentosas
                Utilizando Modelagem em Grafos.
            </strong>
        </p>

        <p>
            O projeto possui finalidade exclusivamente acadêmica,
            educacional e computacional, tendo como objetivo
            estudar a representação e a análise de interações
            medicamentosas por meio da teoria dos grafos.
        </p>

        <div class="disclaimer__limitations">

            <h3>Limitações de uso</h3>

            <ul>
                <li>
                    O sistema não constitui uma ferramenta
                    de avaliação clínica.
                </li>

                <li>
                    As informações apresentadas podem ser
                    incompletas, imprecisas ou desatualizadas.
                </li>

                <li>
                    Os resultados não devem fundamentar decisões
                    sobre tratamentos ou uso de medicamentos.
                </li>

                <li>
                    O sistema não substitui a avaliação ou
                    orientação de profissionais de saúde.
                </li>
            </ul>

        </div>

        <p>
            Ao prosseguir, você declara estar ciente da
            finalidade e das limitações deste sistema.
        </p>

        <div class="disclaimer__actions">

            <x-ui.button
                :block="true"
                :disabled="true"
                data-disclaimer-accept>

                Li e estou ciente (10s)

            </x-ui.button>

            <span class="text-muted text-xs text-center">
                Leia atentamente as informações antes de prosseguir.
            </span>

        </div>

    </div>

</dialog>
