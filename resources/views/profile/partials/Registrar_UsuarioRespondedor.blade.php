<!-- FONDO OSCURO -->
<div
    id="modalRespondedor"
    class="fixed inset-0 z-50 hidden items-center justify-center bg-black/60 backdrop-blur-sm transition-opacity duration-300 ease-out">

    <!-- CONTENIDO -->
    <div class="bg-gradient-to-br from-white to-gray-50 rounded-2xl shadow-2xl w-full max-w-2xl mx-4 transform scale-95 opacity-0 transition-all duration-300 ease-out"
         id="modalRespondedorContent">

        <!-- HEADER -->
        <div class="flex items-center justify-between px-6 py-4 border-b bg-gradient-to-r from-green-500 to-emerald-600 text-white rounded-t-2xl">
            <h2 class="text-xl font-bold tracking-wide">
                ✨ Registrar Usuario Respondedor
            </h2>
            <button
                type="button"
                onclick="cerrarModalRespondedor()"
                class="text-white hover:text-gray-200 text-2xl transition-transform transform hover:rotate-90">
                &times;
            </button>
        </div>

        <form
            id="formRespondedor"
            method="POST"
            action="{{ route('usuarios.respondedor.guardar') }}"
            class="animate-fade-in">

            @csrf

            <div class="p-6 space-y-4">

                <div>
                    <label class="block text-sm font-semibold mb-2 text-gray-700">
                        Nombre completo
                    </label>
                    <input
                        type="text"
                        name="name"
                        id="name"
                        required
                        class="w-full border rounded-lg px-3 py-2 focus:ring-2 focus:ring-green-400 focus:outline-none transition">
                    <p id="errorName" class="text-red-500 text-sm hidden">El nombre no puede estar vacío.</p>
                </div>

                <div>
                    <label class="block text-sm font-semibold mb-2 text-gray-700">
                        Correo electrónico
                    </label>
                    <input
                        type="email"
                        name="email"
                        id="email"
                        required
                        class="w-full border rounded-lg px-3 py-2 focus:ring-2 focus:ring-green-400 focus:outline-none transition">
                    <p id="errorEmail" class="text-red-500 text-sm hidden">Ingresa un correo válido.</p>
                </div>

                <div class="grid grid-cols-2 gap-4">
                    <div>
                        <label class="block text-sm font-semibold mb-2 text-gray-700">
                            Contraseña
                        </label>
                        <input
                            type="password"
                            name="password"
                            id="password"
                            required
                            class="w-full border rounded-lg px-3 py-2 focus:ring-2 focus:ring-green-400 focus:outline-none transition">
                    </div>

                    <div>
                        <label class="block text-sm font-semibold mb-2 text-gray-700">
                            Confirmar contraseña
                        </label>
                        <input
                            type="password"
                            name="password_confirmation"
                            id="password_confirmation"
                            required
                            class="w-full border rounded-lg px-3 py-2 focus:ring-2 focus:ring-green-400 focus:outline-none transition">
                        <p id="errorPassword" class="text-red-500 text-sm hidden">Las contraseñas no coinciden.</p>
                    </div>
                </div>

            </div>

            <div class="flex justify-end gap-3 px-6 py-4 border-t bg-gray-50 rounded-b-2xl">
                <button
                    type="button"
                    onclick="cerrarModalRespondedor()"
                    class="px-4 py-2 bg-gray-200 rounded-lg hover:bg-gray-300 transition">
                    Cancelar
                </button>
                <button
                    type="submit"
                    id="btnGuardarRespondedor"
                    class="px-4 py-2 bg-green-600 text-white rounded-lg hover:bg-green-700 shadow-md transition transform hover:scale-105 disabled:opacity-50 disabled:cursor-not-allowed"
                    disabled>
                    Guardar Respondedor
                </button>
            </div>

        </form>

    </div>
</div>

<script>
function abrirModalRespondedor() {
    const modal = document.getElementById('modalRespondedor');
    const content = document.getElementById('modalRespondedorContent');

    modal.classList.remove('hidden');
    modal.classList.add('flex');

    setTimeout(() => {
        content.classList.remove('scale-95', 'opacity-0');
        content.classList.add('scale-100', 'opacity-100');
    }, 50);
}

function cerrarModalRespondedor() {
    const modal = document.getElementById('modalRespondedor');
    const content = document.getElementById('modalRespondedorContent');

    content.classList.remove('scale-100', 'opacity-100');
    content.classList.add('scale-95', 'opacity-0');

    setTimeout(() => {
        modal.classList.remove('flex');
        modal.classList.add('hidden');
    }, 300);
}

// Validaciones dinámicas
const form = document.getElementById('formRespondedor');
const btnGuardar = document.getElementById('btnGuardarRespondedor');

form.addEventListener('input', () => {
    let valid = true;

    const name = document.getElementById('name');
    const email = document.getElementById('email');
    const password = document.getElementById('password');
    const password_confirmation = document.getElementById('password_confirmation');

    // Validación nombre
    if (name.value.trim() === "") {
        document.getElementById('errorName').classList.remove('hidden');
        valid = false;
    } else {
        document.getElementById('errorName').classList.add('hidden');
    }

    // Validación email
    const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
    if (!emailRegex.test(email.value)) {
        document.getElementById('errorEmail').classList.remove('hidden');
        valid = false;
    } else {
        document.getElementById('errorEmail').classList.add('hidden');
    }

    // Validación contraseñas
    if (password.value !== password_confirmation.value || password.value === "") {
        document.getElementById('errorPassword').classList.remove('hidden');
        valid = false;
    } else {
        document.getElementById('errorPassword').classList.add('hidden');
    }

    // Habilitar o deshabilitar botón
    btnGuardar.disabled = !valid;
});

// Cerrar al hacer click fuera
document.addEventListener('click', function(e){
    const modal = document.getElementById('modalRespondedor');
    const content = document.getElementById('modalRespondedorContent');

    if(e.target === modal){
        cerrarModalRespondedor();
    }
});
</script>
