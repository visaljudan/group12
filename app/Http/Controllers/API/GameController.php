<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Controllers\MainController;
use App\Models\GameStatistic;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class GameController extends MainController

{

    public function play(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'player' => 'required|string|in:rock,paper,scissors',
            'player_id' => 'required|exists:users,id',
        ]);

        if ($validator->fails()) {
            return $this->sendError(422, 'Validation failed', $validator->errors());
        }

        $playerChoice = $request->input('player');
        $playerId = $request->input('player_id');
        $choices = ['rock', 'paper', 'scissors'];
        $computerChoice = $choices[array_rand($choices)];

        // Determine the winner
        $result = $this->determineWinner($playerChoice, $computerChoice);

        // Update player's statistics
        $playerStats = GameStatistic::firstOrCreate(['player_id' => $playerId]);

        if ($result === 'Player wins!') {
            $playerStats->wins += 1;
        } elseif ($result === 'Computer wins!') {
            $playerStats->losses += 1;
        } else {
            $playerStats->ties += 1;
        }

        $playerStats->save();

        // Return the result
        return response()->json([
            'player' => $playerChoice,
            'computer' => $computerChoice,
            'result' => $result,
            'statistics' => $playerStats,
        ]);
    }

    private function determineWinner($player, $computer)
    {
        if ($player === $computer) {
            return 'It\'s a tie!';
        }

        if (
            ($player === 'rock' && $computer === 'scissors') ||
            ($player === 'paper' && $computer === 'rock') ||
            ($player === 'scissors' && $computer === 'paper')
        ) {
            return 'Player wins!';
        }

        return 'Computer wins!';
    }

    public function fetchTop10Players()
    {
        $topPlayers = GameStatistic::select('player_id', 'wins', 'ties', 'losses')
            ->orderByDesc('wins')
            ->orderByDesc('ties')
            ->orderBy('losses')
            ->limit(10)
            ->get();

        return response()->json($topPlayers);
    }
}
