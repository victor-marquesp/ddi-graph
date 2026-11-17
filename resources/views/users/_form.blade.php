<x-form.input
    name="name"
    label="Nome"
    :value="$user->name ?? null"
    placeholder="Nome do usuário"
    autocomplete="name"
    maxlength="255"
    :required="true"
/>

<x-form.input
    name="email"
    label="E-mail"
    type="email"
    :value="$user->email ?? null"
    placeholder="usuario@example.com"
    autocomplete="email"
    maxlength="255"
    :required="true"
/>

<x-form.input
    name="password"
    label="Senha"
    type="password"
    placeholder="Informe uma senha"
    :help="isset($user)
        ? 'Informe uma nova senha com pelo menos 8 caracteres.'
        : 'A senha deve possuir pelo menos 8 caracteres.'"
    autocomplete="new-password"
    minlength="8"
    maxlength="255"
    :required="true"
/>

<x-form.input
    name="password_confirmation"
    label="Confirmação de senha"
    type="password"
    placeholder="Confirme a senha"
    autocomplete="new-password"
    :required="true"
/>
