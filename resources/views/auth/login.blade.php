<x-layouts.app>

    <x-slot:title>login</x-slot:title>

    <div class="container">
        <form method="POST" action="{{ route('auth.login') }}">
            @csrf

            <div class="mb-3">
                <label for="email" class="form-label">Email</label>
                <input type="email" name="email" id="email" placeholder="email@provider.com" class="form-control" />
            </div>

            <div class="mb-3">
                <label for="password" class="form-label">Senha</label>
                <input type="password" name="password" id="password" class="form-control" />
            </div>

            <div class="mb-3 form-check">
                <input type="checkbox" name="remember" id="exampleCheck1" class="form-check-input" >
                <label class="form-check-label" for="exampleCheck1">Manter conectado</label>
            </div>

            <button type="submit" class="btn btn-primary">Entrar</button>

        </form>
    </div>

</x-layouts.app>
