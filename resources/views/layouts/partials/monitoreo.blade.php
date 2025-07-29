<div class="bg-primary px-5 py-5">
    <div class="d-flex justify-content-between align-items-center flex-wrap">
        <div class="text-white fw-bold mx-auto text-center">
            @if (session('success'))
                ✅ {{ session('success') }}
            @elseif (session('error'))
                ❌ {{ session('error') }}
            @else
                ℹ️ Bienvenido al sistema
            @endif
        </div>
    </div>
</div>
