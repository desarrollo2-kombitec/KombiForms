{{-- resources/views/formularios/partials/compartir_modal.blade.php --}}

<div
    id="modalCompartir"
    class="fixed inset-0 z-50 hidden items-center justify-center bg-black/60 p-4">

    <div class="bg-white rounded-2xl shadow-2xl w-full max-w-5xl overflow-hidden">

        {{-- Header --}}
        <div class="flex items-center justify-between bg-purple-600 px-6 py-5">

            <div>
                <h2 class="text-xl font-bold text-white">
                    Compartir formulario
                </h2>

                <p id="tituloFormularioCompartir"
                   class="text-sm text-purple-100 mt-1">
                    Cargando...
                </p>
            </div>


            <button
                type="button"
                onclick="cerrarModalCompartir()"
                class="text-white hover:text-gray-200 text-3xl font-bold">

                &times;

            </button>

        </div>


        {{-- Formulario --}}
        <form
            id="formCompartir"
            method="POST"
            action="">


            @csrf


            <input
                type="hidden"
                id="formulario_id_compartir"
                name="formulario_id">


            <div class="grid grid-cols-1 md:grid-cols-2 gap-6 p-6">


                {{-- Usuarios que ya tienen acceso --}}
                <div>

                    <div class="flex items-center gap-2 mb-3">

                        <span class="text-xl">
                            📌
                        </span>

                        <h3 class="font-bold text-gray-700">
                            Compartido con
                        </h3>

                    </div>


                    <div
                        id="usuariosCompartidos"
                        class="space-y-3 border rounded-xl p-4 bg-gray-50 min-h-[300px]">

                        <p class="text-gray-400 text-sm">
                            Selecciona un formulario...
                        </p>

                    </div>

                </div>



                {{-- Usuarios disponibles --}}
                <div>


                    <div class="flex items-center gap-2 mb-3">

                        <span class="text-xl">
                            👤
                        </span>

                        <h3 class="font-bold text-gray-700">
                            Compartir con
                        </h3>

                    </div>



                    <div
                        id="listaUsuariosDisponibles"
                        class="space-y-3 border rounded-xl p-4 bg-white min-h-[300px] max-h-[350px] overflow-y-auto">


                        {{-- Aquí JavaScript agregará las tarjetas --}}


                        <p class="text-gray-400 text-sm">
                            Cargando usuarios...
                        </p>


                    </div>


                </div>


            </div>



            {{-- Footer --}}
            <div class="flex justify-end gap-3 bg-gray-100 px-6 py-4">


                <button
                    type="button"
                    onclick="cerrarModalCompartir()"
                    class="px-5 py-2 rounded-lg border border-gray-300 bg-white hover:bg-gray-200 transition">

                    Cancelar

                </button>



                <button
                    type="submit"
                    class="px-6 py-2 rounded-lg bg-purple-600 hover:bg-purple-700 text-white font-semibold transition">

                    Compartir

                </button>


            </div>


        </form>


    </div>


</div>