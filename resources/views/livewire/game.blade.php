<div>
    @if($showInfo)
        <div class="grid h-screen place-items-center">
            <div class="text-3xl text-center max-w-4xl margin-auto">
                <p>Hola en este juego tienes {{ $time }} segundos para llegar al final del camino y recolectar las monedas que encuentres.
                    Para no morir debes saltar las rocas y evitar los agujeros.
                </p>

                <p>Al darle al botón de acceder se cargará el tablero y se hará focus en el boton de jugar
                </p>

                <ul class="mt-4">
                    Si pulsas:
                    <li>Alt/Option: Preguntas que hay alrededor</li>
                    <li>Flecha derecha: avanzas hacia la derecha</li>
                    <li>Flecha izquierda: avanzas hacia la izquierda</li>
                    <li>Espacio: Saltas</li>
                    <li>Flecha arriba: subes sin avanzar</li>
                    <li>Enter: volver a jugar</li>
                </ul>
            </div>
            <button wire:click="startGame"
                    class="rounded-md bg-indigo-600 px-3.5 py-2.5 text-sm font-semibold text-white shadow-sm hover:bg-indigo-500 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-600">
                Empezar
            </button>
        </div>
    @endif

    @if($showBoard)
        <div class="grid h-screen place-items-center"
             wire:poll.1s="tick">
            <div class="flex justify-end" aria-hidden="true">
                <div class="w-48 text-7xl text-center align-content-center"
                     aria-label="puntuación">
                    {{ $score }} <span class="text-xl">puntos</span>
                </div>
                <div class=" w-48 text-7xl text-center align-content-center"
                     aria-label="tiempo">
                    {{ $time }} <span class="text-xl">segundos</span>
                </div>
            </div>

            <div class="flex border border-indigo-400 p-4 m-4" role="status" aria-live="assertive" aria-atomic="true">
                <ul>
                    @foreach($announcements as $announcement)
                        <li> {{ $announcement }}</li>
                    @endforeach
                </ul>
            </div>

            <div class="m-4">
                <button wire:model="movement"
                        wire:keydown.right="moveRight"
                        wire:keydown.left="moveLeft"
                        wire:keydown.up="moveUp"
                        wire:keydown.space="jump"
                        wire:keydown.alt="ask"
                        wire:keydown.enter="playAgain"
                        class="rounded-md bg-indigo-600 px-3.5 py-2.5 text-sm font-semibold text-white shadow-sm hover:bg-indigo-500 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-600"
                        role="cell">
                    Usa las teclas para moverte
                </button>
            </div>

            <table class="border-collapse border-0" aria-hidden="true">
                <thead></thead>
                <tbody>
                @foreach($board as $row)
                    <tr>
                        @foreach($row as $cell)
                            <td>
                                <div class="content-around grid text-center w-32 h-32 border border-gray-400 text-7xl {{ $cell['color'] ?? 'bg-gray-200' }}">
                                    <span aria-hidden="true">{{ $cell['element'] }}</span>
                                    <span class="sr-only">
                                        {{ $cell['element'] === '💃' ? 'Personaje' : '' }}
                                        {{ $cell['element'] === '🪨' ? 'Roca' : '' }}
                                        {{ $cell['element'] === '🕳' ? 'Agujero' : '' }}
                                        {{ $cell['element'] === '🪙' ? 'Moneda' : '' }}
                                    </span>
                                </div>
                            </td>
                        @endforeach
                    </tr>
                @endforeach
                </tbody>
            </table>
        </div>
    @endif
</div>
