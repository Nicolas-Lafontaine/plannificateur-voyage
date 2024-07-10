<div>
    <form wire:submit.prevent="submit">
        <div>
            <label for="email">Email</label>
            <input type="email" wire:model="email" required>
            @error('email') <span class="error">{{ $message }}</span> @enderror
        </div>

        <div>
            <label for="password">Password</label>
            <input type="password" wire:model="password" required>
            @error('password') <span class="error">{{ $message }}</span> @enderror
        </div>

        <div>
            <button type="submit">Se connecter</button>
            <button type="button" wire:click="redirectToRegister">Créer un compte</button>
        </div>
    </form>
</div>
