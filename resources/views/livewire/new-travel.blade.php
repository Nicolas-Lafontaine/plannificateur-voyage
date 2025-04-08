<div class="d-flex justify-content-center align-items-center" style="min-height: 100vh;">
    <form wire:submit.prevent="submit" class="border p-4 rounded shadow" style="width: 400px;">
        <h2 class="text-center mb-4">Créer un nouveau voyage</h2>

        <div class="form-group">
            <label for="travelName">Titre du voyage :</label>
            <input type="text" id="travelName" wire:model="travelName" class="form-control" required>
        </div>

        <div class="form-group">
            <label for="isPublic">Voyage public ?</label>
            <div class="form-check form-switch">
                <input type="checkbox" id="isPublic" wire:model="isPublic" class="form-check-input">
                <label class="form-check-label" for="isPublic">Oui</label>
            </div>
        </div>

        <button type="submit" class="btn btn-primary btn-block">Soumettre</button>
    </form>
</div>
