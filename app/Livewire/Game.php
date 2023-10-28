<?php

namespace App\Livewire;

use Livewire\Component;

class Game extends Component
{
    public $board = [];
    public $time = 30; // seconds
    public $score = 0;
    public $alive = true;
    public $hasWon = false;
    public $x = 0;
    public $y = 1;
    public $announcements = [];
    public $showInfo = false;
    public $showBoard = false;
    public $movement = null;

    public function mount()
    {
        $this->showInfo = true;
        $this->generateBoard();
    }

    public function tick()
    {
        if ($this->alive && ! $this->hasWon) {
            $this->time--;

            if (isset($this->board[$this->y][$this->x]) && $this->board[$this->y][$this->x]['gravity'] == 0) {
                $this->board[$this->y][$this->x]['element'] = '';
                $this->y++;
                $this->announcements = [];
                $this->checkNewPosition();
            }

            if ($this->time === 0) {
                $this->alive = false;
                $this->announcements = ['Game Over'];
            }
        }
    }

    public function startGame()
    {
        $this->showInfo = false;
        $this->showBoard = true;

        $this->ask();
    }

    public function generateBoard()
    {
        $this->board = [
            [
                ['gravity' => 0, 'win' => 0, 'element' => '', 'color' => 'bg-sky-200'],
                ['gravity' => 0, 'win' => 0, 'element' => '🪙', 'color' => 'bg-sky-200'],
                ['gravity' => 1, 'win' => 0, 'element' => '', 'color' => 'bg-sky-200'],
                ['gravity' => 0, 'win' => 0, 'element' => '', 'color' => 'bg-sky-200'],
                ['gravity' => 0, 'win' => 0, 'element' => '', 'color' => 'bg-sky-200'],
                ['gravity' => 0, 'win' => 0, 'element' => '', 'color' => 'bg-sky-200'],
                ['gravity' => 1, 'win' => 0, 'element' => '', 'color' => 'bg-sky-200'],
                ['gravity' => 1, 'win' => 0, 'element' => '', 'color' => 'bg-sky-200'],
                ['gravity' => 0, 'win' => 0, 'element' => '🪙', 'color' => 'bg-sky-200'],
                ['gravity' => 0, 'win' => 0, 'element' => '', 'color' => 'bg-sky-200'],
                ['gravity' => 0, 'win' => 0, 'element' => '', 'color' => 'bg-sky-200'],
            ],
            [
                ['gravity' => 1, 'win' => 0, 'element' => '💃', 'color' => 'bg-sky-200'],
                ['gravity' => 1, 'win' => 0, 'element' => '', 'color' => 'bg-sky-200'],
                ['gravity' => 1, 'win' => 0, 'element' => '🪨', 'color' => 'bg-sky-200'],
                ['gravity' => 1, 'win' => 0, 'element' => '', 'color' => 'bg-sky-200'],
                ['gravity' => 0, 'win' => 0, 'element' => '', 'color' => 'bg-sky-200'],
                ['gravity' => 1, 'win' => 0, 'element' => '🪙', 'color' => 'bg-sky-200'],
                ['gravity' => 1, 'win' => 0, 'element' => '🪨', 'color' => 'bg-sky-200'],
                ['gravity' => 1, 'win' => 0, 'element' => '🪨', 'color' => 'bg-sky-200'],
                ['gravity' => 1, 'win' => 0, 'element' => '', 'color' => 'bg-sky-200'],
                ['gravity' => 1, 'win' => 0, 'element' => '🪙', 'color' => 'bg-sky-200'],
                ['gravity' => 1, 'win' => 1, 'element' => '', 'color' => 'bg-sky-200'],
            ],
            [
                ['gravity' => 0, 'win' => 0, 'element' => '', 'color' => 'bg-yellow-800'],
                ['gravity' => 0, 'win' => 0, 'element' => '', 'color' => 'bg-yellow-800'],
                ['gravity' => 0, 'win' => 0, 'element' => '', 'color' => 'bg-yellow-800'],
                ['gravity' => 0, 'win' => 0, 'element' => '', 'color' => 'bg-yellow-800'],
                ['gravity' => 0, 'win' => 0, 'element' => '🕳️', 'color' => 'bg-yellow-800'],
                ['gravity' => 0, 'win' => 0, 'element' => '', 'color' => 'bg-yellow-800'],
                ['gravity' => 0, 'win' => 0, 'element' => '', 'color' => 'bg-yellow-800'],
                ['gravity' => 0, 'win' => 0, 'element' => '', 'color' => 'bg-yellow-800'],
                ['gravity' => 0, 'win' => 0, 'element' => '', 'color' => 'bg-yellow-800'],
                ['gravity' => 0, 'win' => 0, 'element' => '', 'color' => 'bg-yellow-800'],
                ['gravity' => 0, 'win' => 0, 'element' => '', 'color' => 'bg-yellow-800'],
            ]
        ];
    }

    public function moveLeft()
    {
        if (! $this->alive) {
            return;
        }
        $this->announcements = [];

        $this->board[$this->y][$this->x]['element'] = '';
        $this->x--;

        $this->checkNewPosition();
    }

    public function moveRight()
    {
        if (! $this->alive) {
            return;
        }
        $this->announcements = [];

        $this->board[$this->y][$this->x]['element'] = '';
        $this->x++;

        $this->checkNewPosition();
    }

    public function moveUp()
    {
        if (! $this->alive) {
            return;
        }
        $this->announcements = [];

        $this->board[$this->y][$this->x]['element'] = '';
        $this->y--;
        $this->checkNewPosition();
    }

    public function jump()
    {
        if (! $this->alive) {
            return;
        }
        $this->announcements = [];

        $this->board[$this->y][$this->x]['element'] = '';
        $this->x++;
        if (isset($this->board[$this->y + 1][$this->x + 1]) && $this->board[$this->y + 1][$this->x]['element'] == '🕳️') {
            $this->x++;
        }
        if ($this->y > 0) {
            $this->y--;
            $this->checkNewPosition();
        }
    }

    protected function checkNewPosition(): void
    {
        if (isset($this->board[$this->y][$this->x])) {
            if ($this->board[$this->y][$this->x]['win'] == 1) {
                $this->hasWon = true;
                $this->score += $this->time;
                $this->announcements[] = 'Has ganado con ' . $this->score . ' puntos!';
                $this->board[$this->y][$this->x]['element'] = '👩‍🦯';
                return;
            }

            switch ($this->board[$this->y][$this->x]['element']) {
                case '🪙':
                    $this->score++;
                    $this->board[$this->y][$this->x]['element'] = '💃';
                    $this->announcements[] = 'Has ganado una moneda!';
                    break;
                case '🪨':
                    $this->alive = false;
                    $this->announcements[] = 'Te comiste una roca. Estás muerto';
                    $this->board[$this->y][$this->x]['element'] = '😱';
                    break;
                case '🕳️':
                    $this->alive = false;
                    $this->announcements[] = 'Te caíste al agujero! Estás muerto';
                    $this->board[$this->y][$this->x]['element'] = '😱';
                    break;
                default:
                    $this->board[$this->y][$this->x]['element'] = '💃';
                    $this->ask();
            }
        }
    }

    public function ask()
    {
        $this->announcements = [];

        if (! $this->alive) {
            $this->announcements[] = 'Estás muerto!';
            return;
        }

        if ($this->hasWon) {
            $this->announcements[] = 'Has ganado con ' . $this->score . ' puntos!';
            return;
        }

        if (isset($this->board[$this->y][$this->x + 1])) {
            switch ($this->board[$this->y][$this->x + 1]['element']) {
                case '🪙':
                    $this->announcements[] = 'Moneda delante';
                    break;
                case '🪨':
                    $this->announcements[] = 'Hay una roca delante';
                    break;
                case '🕳️':
                    $this->announcements[] = 'Hay un agujero delante';
                    break;
                default:
                    $this->announcements[] = 'La siguiente casilla está vacía';
                    break;
            }
        }

        if (isset($this->board[$this->y - 1][$this->x])) {
            switch ($this->board[$this->y - 1][$this->x]['element']) {
                case '🪙':
                    $this->announcements[] = 'Moneda arriba';
                    break;
                default:
                    break;
            }
        }

        if (isset($this->board[$this->y + 1][$this->x + 1]['element'])) {
            switch ($this->board[$this->y + 1][$this->x + 1]['element']) {
                case '🕳️':
                    $this->announcements[] = 'Agujero delante';
                    break;
                default:
                    break;
            }
        }

        if (isset($this->board[$this->y + 1][$this->x])) {
            if ($this->board[$this->y + 1][$this->x]['element'] === '🪙') {
                $this->announcements[] = 'Moneda arriba';
            }
        }
    }

    public function describeEmoji($element)
    {
        switch ($element) {
            case '🪙':
                return 'Moneda';
            case '🪨':
                return 'Roca';
            case '🕳️':
                return 'Agujero';
            case '💃':
                return 'Personaje';
            default:
                return 'Vacio';
        }
    }

    public function render()
    {
        return view('livewire.game');
    }

}
