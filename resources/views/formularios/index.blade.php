@extends('layouts.app')

@section('content')
<div class="p-6">

    <div class="flex items-center justify-between mb-6">
        <h1 class="text-3xl font-bold text-[#025742] drop-shadow">
            📋 Lista de Formularios
        </h1>

        {{-- Botón Crear Nuevo Formulario --}}
        <a href="{{ route('formularios.crear') }}"
           class="inline-flex items-center gap-2 bg-[#025742] hover:bg-green-700 text-white font-semibold px-4 py-2 rounded-lg shadow transition-all duration-200 transform hover:scale-105">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                      d="M12 4v16m8-8H4"/>
            </svg>
            Nuevo Formulario
        </a>
    </div>

    <div class="bg-white shadow-xl rounded-2xl overflow-hidden border border-gray-200">
        <table class="min-w-full divide-y divide-gray-200">
            <thead class="bg-[#025742] text-white">
                <tr>
                    <th class="px-4 py-3 text-left text-xs font-semibold uppercase">Título</th>
                    <th class="px-4 py-3 text-left text-xs font-semibold uppercase">Estado</th>
                    <th class="px-4 py-3 text-left text-xs font-semibold uppercase">Fecha inicio</th>
                    <th class="px-4 py-3 text-left text-xs font-semibold uppercase">Fecha fin</th>
                    <th class="px-4 py-3 text-left text-xs font-semibold uppercase">Respuestas</th>
                    <th class="px-4 py-3 text-right text-xs font-semibold uppercase">Acciones</th>
                </tr>
            </thead>

            <tbody class="divide-y divide-gray-100">
                @forelse ($formularios as $form)
                <tr class="transition transform hover:scale-[1.015] hover:bg-green-50"
                    x-data="{
                        fechaInicio: '{{ $form->fecha_inicio }}',
                        fechaFin: '{{ $form->fecha_fin }}',
                        activo: {{ (int) $form->activo }},
                        estado: '{{ $form->estado ?? '' }}',
                        init(){
                            let ahora = new Date();
                            if(this.fechaFin && new Date(this.fechaFin) <= ahora){
                                this.activo = 0;
                                this.estado = 'Inactivo';
                            } else if(this.fechaInicio && new Date(this.fechaInicio) <= ahora && (!this.fechaFin || new Date(this.fechaFin) > ahora)){
                                this.activo = 1;
                                this.estado = 'Activo';
                            } else if(this.fechaInicio && new Date(this.fechaInicio) > ahora){
                                this.activo = 0;
                                this.estado = 'Programado';
                            } else {
                                // Sin fechas: respetar lo que ya tenga en BD
                                this.estado = this.activo ? 'Activo' : 'Inactivo';
                            }
                        }
                    }"
                >





                    <td class="px-4 py-4 text-gray-800 font-medium">
                        {{ $form->titulo }}
                    </td>

                    
                  {{-- Estado: mostrar Activo/Inactivo/Programado calculado --}}
                    {{-- Estado: mostrar Activo/Inactivo/Programado calculado --}}
                    <td class="px-4 py-4">
                        <template x-if="estado === 'Programado'">
                            <span class="inline-flex items-center gap-2 px-4 py-1.5 rounded-full text-sm font-bold 
                                        bg-gradient-to-r from-blue-400 to-blue-600 text-white shadow-md">
                                <span class="w-3 h-3 bg-white rounded-full animate-bounce"></span>
                                Programado
                            </span>
                        </template>

                        <template x-if="estado === 'Activo'">
                            <span class="inline-flex items-center gap-2 px-4 py-1.5 rounded-full text-sm font-bold 
                                        bg-gradient-to-r from-green-400 to-green-600 text-white shadow-md">
                                <span class="w-3 h-3 bg-white rounded-full animate-pulse"></span>
                                Activo
                            </span>
                        </template>

                        <template x-if="estado === 'Inactivo'">
                            <span class="inline-flex items-center gap-2 px-4 py-1.5 rounded-full text-sm font-bold 
                                        bg-gradient-to-r from-red-400 to-red-600 text-white shadow-md">
                                <span class="w-3 h-3 bg-white rounded-full"></span>
                                Inactivo
                            </span>
                        </template>
                    </td>



                    <td class="px-4 py-4 text-gray-600">
                        {{ $form->fecha_inicio ? $form->fecha_inicio : '------------' }}
                    </td>
                    <td class="px-4 py-4 text-gray-600">
                        {{ $form->fecha_fin ? $form->fecha_fin : '------------' }}
                    </td>

                    <td class="px-4 py-4 text-gray-600">
                        {{ $form->respuestas_count }}
                    </td>

                    <td class="px-4 py-4 text-right space-x-2">
                        {{-- Botones de acción --}}
                        <a href="{{ route('formularios.editar', $form->id) }}" 
                           class="inline-block bg-blue-500 hover:bg-blue-600 text-white text-xs px-3 py-1 rounded shadow transition">
                           Editar
                        </a>

                        <a href="#"
                           onclick="copiarEnlace('{{ route('formularios.acceder', $form->token) }}')"
                           class="inline-block bg-indigo-500 hover:bg-indigo-600 text-white text-xs px-3 py-1 rounded shadow transition">
                           Ver enlace
                        </a>

                        <a href="{{ route('formularios.concentrado', $form->id) }}" 
                           class="inline-block bg-green-600 hover:bg-green-700 text-white text-xs px-3 py-1 rounded shadow transition">
                           Respuestas
                        </a>

                        <form action="#" method="POST" class="inline-block">
                            @csrf
                            @method('DELETE')
                            <button class="bg-red-500 hover:bg-red-600 text-white text-xs px-3 py-1 rounded shadow transition">
                                Eliminar
                            </button>
                        </form>

                       
                        {{-- Configuración --}}
                        <!--<a href="{{ route('formularios.configuracion', ['id' => $form->id, 'from' => 'index']) }}"
                        class="inline-flex items-center justify-center w-9 h-9 bg-gray-200 hover:bg-gray-300 rounded-full shadow transition"
                        title="Configuración del formulario">
                            <img src="https://cdn-icons-png.freepik.com/256/889/889717.png?semt=ais_white_label"
                                alt="Configuración"
                                class="w-5 h-5" />
                        </a>-->

                        {{-- Configuración --}}
                        <a href="{{ route('formularios.configuracion', ['id' => $form->id, 'from' => 'index']) }}"
                        class="inline-flex items-center justify-center w-9 h-9 bg-gray-400 hover:bg-gray-500 text-white rounded-full shadow transition"
                        title="Configuración del formulario">
                            <i class="bi bi-gear-fill text-lg"></i>
                        </a>


                                                {{-- Compartir --}}
                        <a href="#"
                           onclick="abrirModalCompartir({{ $form->id }}); return false;"
                           class="inline-flex items-center justify-center w-9 h-9 bg-purple-500 hover:bg-purple-600 text-white rounded-full shadow transition"
                           title="Compartir formulario">

                            <i class="bi bi-share-fill text-lg"></i>

                        </a>

                    </td>

                </tr>

                @empty
                <tr>
                    <td colspan="4" class="px-4 py-6 text-center text-gray-500">
                        No hay formularios creados.
                    </td>
                </tr>
                @endforelse

            </tbody>
        </table>

    </div>
</div>

{{-- ========================================================= --}}
{{-- MODAL ÚNICO PARA COMPARTIR FORMULARIOS --}}
{{-- ========================================================= --}}
@include('formularios.partials.compartir_modal')

<script>


  
 /**
     * Abre el modal.
     * Más adelante aquí mismo cargaremos la información mediante AJAX.
     */
    

async function abrirModalCompartir(formularioId)
{
    const modal = document.getElementById('modalCompartir');

    modal.classList.remove('hidden');
    modal.classList.add('flex');

    document.getElementById('tituloFormularioCompartir').innerHTML =
        'Cargando...';

    document.getElementById('usuariosCompartidos').innerHTML = `
        <p class="text-gray-400">
            Cargando...
        </p>
    `;

    document.getElementById('listaUsuariosDisponibles').innerHTML = `
        <p class="text-gray-400">
            Cargando usuarios...
        </p>
    `;

    try
    {
        const response = await fetch(`/formularios/${formularioId}/compartir`);

        if (!response.ok)
        {
            throw new Error('Error obteniendo datos');
        }

        const datos = await response.json();

        console.log(datos);

        document.getElementById('formulario_id_compartir').value =
            datos.id;

        document.getElementById('formCompartir').action =
            `/formularios/${datos.id}/compartir`;

        document.getElementById('tituloFormularioCompartir').innerHTML =
            datos.titulo;

        /*
        |--------------------------------------------------------------------------
        | GUARDAR DATOS EN MEMORIA
        |--------------------------------------------------------------------------
        */

        // Todos los creadores
        window.creadoresDisponibles = [
            ...datos.creadores
        ];

        // Usuarios que YA están compartidos (solo columna izquierda)
        window.usuariosCompartidosActuales = [
            ...datos.compartidos
        ];

        // Usuarios seleccionados para guardar (checkboxes)
        // Inician con los que ya estaban compartidos
        window.usuariosSeleccionadosPendientes = [
            ...datos.compartidos
        ];

        /*
        |--------------------------------------------------------------------------
        | Pintar pantalla
        |--------------------------------------------------------------------------
        */

        renderUsuariosCompartidos();

        renderUsuariosDisponibles(
            window.creadoresDisponibles
        );
    }
    catch (error)
    {
        console.error(error);

        alert('Error cargando usuarios para compartir');
    }
}

function renderUsuariosCompartidos()
{

    const contenedor =
        document.getElementById('usuariosCompartidos');



    const usuarios =
        window.usuariosCompartidosActuales || [];



    if(usuarios.length === 0)
    {

        contenedor.innerHTML = `
            <div class="text-center text-gray-400 py-8">
                Este formulario todavía no está compartido.
            </div>
        `;

        return;

    }



    let html = '';



    usuarios.forEach(usuario => {


        html += `

        <div class="
            flex
            items-center
            justify-between
            bg-white
            border
            rounded-xl
            p-3
            shadow-sm">


            <div class="flex items-center gap-3">


                <div class="
                    w-10
                    h-10
                    rounded-full
                    bg-purple-100
                    flex
                    items-center
                    justify-center
                    text-purple-600
                    font-bold">

                    ${usuario.name.charAt(0).toUpperCase()}

                </div>



                <div>

                    <p class="font-semibold text-gray-700">
                        ${usuario.name}
                    </p>


                    <p class="text-sm text-gray-500">
                        ${usuario.email}
                    </p>


                </div>


            </div>



            <button
                type="button"
                onclick="eliminarUsuarioCompartido(${usuario.id})"
                class="
                    text-red-500
                    hover:bg-red-100
                    rounded-full
                    w-9
                    h-9
                    text-xl
                    font-bold
                    transition">

                ×

            </button>


        </div>

        `;


    });



    contenedor.innerHTML = html;


}

function renderUsuariosDisponibles(creadores)
{

    const contenedor =
        document.getElementById('listaUsuariosDisponibles');


    contenedor.innerHTML = '';



    // Usuarios seleccionados actualmente
    const seleccionados =
        window.usuariosSeleccionadosPendientes || [];



    // Usuarios que YA están compartidos
    const compartidos =
        window.usuariosCompartidosActuales || [];



    creadores.forEach(usuario => {


        const estaSeleccionado =
            seleccionados.some(
                u => u.id == usuario.id
            );



        const yaCompartido =
            compartidos.some(
                u => u.id == usuario.id
            );



        const tarjeta =
            document.createElement('label');



        tarjeta.className = `
            flex
            items-center
            gap-3
            cursor-pointer
            border
            rounded-xl
            p-3
            transition
            shadow-sm
            ${
                estaSeleccionado
                ?
                'bg-purple-600 border-purple-700 text-white shadow-lg'
                :
                'bg-white hover:bg-purple-50'
            }
        `;



        tarjeta.innerHTML = `

            <input
                type="checkbox"
                name="usuarios[]"
                value="${usuario.id}"
                class="hidden"
                ${estaSeleccionado ? 'checked' : ''}
            >


            <div class="
                usuario-avatar
                w-10
                h-10
                rounded-full
                flex
                items-center
                justify-center
                font-bold
                ${
                    estaSeleccionado
                    ?
                    'bg-white text-purple-600'
                    :
                    'bg-gray-200 text-gray-600'
                }
            ">

                ${usuario.name.charAt(0).toUpperCase()}

            </div>



            <div class="flex-1">

                <p class="
                    font-semibold
                    ${
                        estaSeleccionado
                        ?
                        'text-white'
                        :
                        'text-gray-700'
                    }
                ">
                    ${usuario.name}
                </p>



                <p class="
                    text-sm
                    ${
                        estaSeleccionado
                        ?
                        'text-purple-100'
                        :
                        'text-gray-500'
                    }
                ">
                    ${usuario.email}
                </p>

            </div>

            ${
                yaCompartido
                ? `
                    <span
                        class="text-xs px-2 py-1 rounded-full bg-white/20 text-white whitespace-nowrap">
                        Compartido
                    </span>
                `
                : ''
            }

        `;



        const checkbox =
            tarjeta.querySelector('input');



        tarjeta.onclick = function(e)
        {

            e.preventDefault();



            /*
            |--------------------------------------------------------------------------
            | Si ya está compartido, NO permitir desmarcarlo.
            | Debe eliminarse únicamente desde la X del panel izquierdo.
            |--------------------------------------------------------------------------
            */

            if (yaCompartido && checkbox.checked)
            {
                return;
            }



            checkbox.checked = !checkbox.checked;



            if(checkbox.checked)
            {

                const existe =
                    window.usuariosSeleccionadosPendientes.some(
                        u => u.id == usuario.id
                    );


                if(!existe)
                {
                    window.usuariosSeleccionadosPendientes.push(usuario);
                }

            }
            else
            {

                window.usuariosSeleccionadosPendientes =
                    window.usuariosSeleccionadosPendientes.filter(
                        u => u.id != usuario.id
                    );

            }



            renderUsuariosDisponibles(
                window.creadoresDisponibles
            );

        };



        contenedor.appendChild(tarjeta);


    });


}

function eliminarUsuarioCompartido(usuarioId)
{

    /*
    |--------------------------------------------------------------------------
    | Quitar de los usuarios que YA están compartidos
    |--------------------------------------------------------------------------
    */

    window.usuariosCompartidosActuales =
        window.usuariosCompartidosActuales.filter(
            usuario => usuario.id != usuarioId
        );



    /*
    |--------------------------------------------------------------------------
    | Desmarcar también el checkbox correspondiente
    |--------------------------------------------------------------------------
    */

    window.usuariosSeleccionadosPendientes =
        window.usuariosSeleccionadosPendientes.filter(
            usuario => usuario.id != usuarioId
        );



    /*
    |--------------------------------------------------------------------------
    | Actualizar ambas columnas
    |--------------------------------------------------------------------------
    */

    renderUsuariosCompartidos();

    renderUsuariosDisponibles(
        window.creadoresDisponibles
    );

}

    /**
     * Cierra el modal.
     */
    function cerrarModalCompartir()
    {
        const modal = document.getElementById('modalCompartir');

        modal.classList.remove('flex');
        modal.classList.add('hidden');
    }

    /**
     * Cerrar al hacer clic sobre el fondo oscuro.
     */
    document.addEventListener('click', function(e){

        const modal = document.getElementById('modalCompartir');

        if(!modal) return;

        if(e.target === modal){
            cerrarModalCompartir();
        }

    });

    /**
     * Cerrar con la tecla ESC.
     */
    document.addEventListener('keydown', function(e){

        if(e.key === 'Escape'){
            cerrarModalCompartir();
        }

    });

// copiarEnlace()



    function copiarEnlace(url) {
        navigator.clipboard.writeText(url).then(function() {
            alert("Enlace copiado: " + url);
        }, function(err) {
            console.error("Error al copiar enlace: ", err);
        });
    }

</script>

<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">

@endsection