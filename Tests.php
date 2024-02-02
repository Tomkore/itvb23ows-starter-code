<?php
    use PHPUnit\Framework\TestCase;

    include_once "util.php";
    class Tests extends TestCase
    {
        public function testIsValidPlayPosition()
        {
            // Stel een testbord op
            $board = [
                '0,0' => [[0, 'Q']],
                '0,1' => [[1, 'Q']]
            ];
            $player = 0;

            // Test een geldige positie
            $this->assertTrue(
                isValidPlayPosition($player, '0,-1', $board),
                "Position should be valid for player player 0"
            );

            // Test een ongeldige positie (al bezet)
            $this->assertFalse(
                isValidPlayPosition($player, '0,0', $board),
                "Position should be invalid as it's already occupied"
            );

            $this->assertFalse(
                isValidPlayPosition($player,'0,2', $board),
                "Position should be invalid as it's neighbours contain a different colour"
            );
        }

        public function testIsOwnTile(){
            $board = [
                '0,0' => [[0, 'Q']],
                '0,1' => [[1, 'Q']],
                '1,1' => [[0, 'B'], [1, 'B']]
            ];
            $player = 0;
            $this->assertTrue(
                isOwnTile($player, '0,0', $board),
                "This tile belongs to player 0"
            );
            $this->assertTrue(
                isOwnTile(1, '0,1', $board),
                "This tile belongs to player 1"
            );
            $this->assertFalse(
                isOwnTile($player, '0,1', $board),
                "This tile does not belong to player 0"
            );
            $this->assertTrue(
                isOwnTile(1, '1,1', $board),
                "Top tile belongs to 1"
            );

        }

        public function testHasNeighbour(){
            $board = [
                '0,0' => [[0, 'Q']],
                '0,1' => [[1, 'Q']]
            ];
            $this->assertFalse(
                hasNeighBour("-1,-1", $board),
                "this has no neighbour"
            );
            $this->assertTrue(
                hasNeighBour("1,0", $board),
                "this tile has a neighbour"
            );
        }

        public function testSlide(){
            $board = [
                '0,0' => [[0, 'Q']],
                '1,0' => [[1, 'Q']]
            ];
            $this->assertTrue(
                slide($board, "0,0", "0,1"),
                "This tile can move"
            );

            $this->assertTrue(
                isNeighbour("0,0", "0,1"),
                "these tiles are neighbours"
            );
        }

        public function testCanPlay(){
            $board = [
                '0,0' => [[0, 'B']],
                '0,1' => [[1, 'B']],
                '0,-1' => [[0, 'B']],
                '0,2' => [[1, 'B']],
                '0,-2' => [[0, 'A']],
                '0,3' => [[1, 'A']],
            ];
            $hand=["Q" => 1, "B" => 0, "S" => 2, "A" => 2, "G" => 3];
            $piece = "Q";
            $player = 0;
            $to = "0,-3";
            $this->assertTrue(
                canPlay($hand, $piece, $player, $board, $to),
                "This is a valid move"
            );
            $board = [
                '0,1' => [[0, 'Q']],
                '1,1' => [[1, 'Q']]
            ];
            $hand=["Q" => 0, "B" => 2, "S" => 2, "A" => 2, "G" => 3];
            $this->assertTrue(
                canPlay($hand, "B", 0, $board, "0,0"),
                "this move can be played"
            );
        }

        public function testJump(){
            $board = [
                '0,0' => [[0, 'Q']],
                '0,1' => [[1, 'Q']],
                '0,-1' =>[[0, 'G']]
            ];
            $this->assertTrue(
                jump('0,2', $board, '0,-1'),
                "This is a valid jump"
            );
            $this->assertFalse(
                jump('1,-1', $board, '0,1'),
                "This is not a valid jump"
            );
        }

        public function testAntMove(){
            $board = [
                '0,0' => [[0, 'Q']],
                '0,1' => [[1, 'Q']],
                '0,-1' =>[[0, 'A']],
                '0,2' =>[[0, 'B']],
            ];
            $this->assertTrue(
                callAntMove("0,-1", $board, "1,2"),
                "1 this is a valid move for an ant"
            );
            $this->assertTrue(
                callAntMove("0,-1", $board, "0,3"),
                "2 this is a valid move for an ant"
            );
            $this->assertTrue(
                callAntMove("0,-1", $board, "1,-1"),
                "this is a valid antmove"
            );
            $this->assertTrue(
                callAntMove("0,-1", $board, "1,1"),
                "this is a valid antmove"
            );
            $this->assertTrue(
                callAntMove("0,-1", $board, "-1,1"),
                "this is a valid antmove"
            );
        }

        public function testSpiderMove(){
            $board = [
                '0,0' => [[0, 'Q']],
                '0,1' => [[1, 'Q']],
                '0,-1' =>[[0, 'S']],
                '0,2' =>[[0, 'B']],
            ];
            $this->assertTrue(
                callSpiderMove("0,-1", $board, "1,1"),
                "this is a valid spidermove"
            );
            $this->assertTrue(
                callSpiderMove("0,-1", $board, "-1,2"),
                "1 this is a valid move for a spider"
            );
            $this->assertFalse(
                callSpiderMove("0,-1", $board, "1,-1"),
                "2 this is not a valid spidermove"
            );
            $this->assertFalse(
                callSpiderMove("0,-1", $board, "-1,0"),
                "4 this is not a valid spidermove"
            );
        }

        public function testMove(){
            $board = [
                '0,0' => [[1, 'Q']],
                '0,-1' => [[0, 'Q']],
                '1,-1' =>[[0, 'S']],
                '1,0' =>[[0, 'B']],
                '0,1' =>[[0,'A']],
                '-1,1' =>[[0,'A']],
                '-1,0' =>[[0,'A']],
            ];
            $hand=["Q" => 0, "B" => 1, "S" => 2, "A" => 3, "G" => 3];

            $board2 = [
                '0,0' => [[0, 'Q']],
                '0,1' => [[1, 'Q']],
                '0,-1' =>[[0, 'B']],
                '0,2' =>[[1, 'B']]
            ];
            $hand2=["Q" => 0, "B" => 1, "S" => 2, "A" => 3, "G" => 3];
            $this->assertTrue(
                move('0,2', '1,1',1, $board2, $hand2),
                'this move is valid'
            );
            $this->assertFalse(
                move('0,0', '-1,0', 1, $board, $hand),
                'this move is not valid'
            );
        }

        public function testCanPAss(){
            $board1 = [
            '0,0' => [[0, 'Q']],
            ];
            $to1 = [];
            foreach ($GLOBALS['OFFSETS'] as $pq) {
                foreach (array_keys($board1) as $pos) {
                    $pq2 = explode(',', $pos);
                    $to1[] = ($pq[0] + $pq2[0]).','.($pq[1] + $pq2[1]);
                }
            }
            $to1 = array_unique($to1);
            if (!count($to1)) $to1[] = '0,0';
            $player1 = 1;
            $hand1=["Q" => 0, "B" => 1, "S" => 2, "A" => 3, "G" => 3];
            $board2 = [
                '0,0' => [[0, 'Q']],
                '0,1' => [[1, 'Q']],
                '0,-1' =>[[0, 'B']],
                '0,2' =>[[1, 'B']]
            ];
            $to2 = [];
            foreach ($GLOBALS['OFFSETS'] as $pq) {
                foreach (array_keys($board2) as $pos) {
                    $pq2 = explode(',', $pos);
                    $to2[] = ($pq[0] + $pq2[0]).','.($pq[1] + $pq2[1]);
                }
            }
            $to2 = array_unique($to2);
            if (!count($to2)) $to2[] = '0,0';
            $player2 = 1;
            $hand2=["Q" => 0, "B" => 1, "S" => 2, "A" => 3, "G" => 3];
            $board3 = [
                '0,0' => [[1, 'Q']],
                '0,-1' => [[0, 'Q']],
                '1,-1' =>[[0, 'S']],
                '1,0' =>[[0, 'B']],
                '0,1' =>[[0,'A']],
                '-1,1' =>[[0,'A']],
                '-1,0' =>[[0,'A']],
            ];
            $to3 = [];
            foreach ($GLOBALS['OFFSETS'] as $pq) {
                foreach (array_keys($board3) as $pos) {
                    $pq2 = explode(',', $pos);
                    $to3[] = ($pq[0] + $pq2[0]).','.($pq[1] + $pq2[1]);
                }
            }
            $to3 = array_unique($to3);
            if (!count($to3)) $to3[] = '0,0';
            $player3 = 1;
            $hand3=["Q" => 0, "B" => 1, "S" => 2, "A" => 3, "G" => 3];
            $this->assertFalse(
                canPass($board1, $to1, $player1, $hand1),
                'this player can not pass, because there is only one card.'
            );
            $this->assertFalse(
                canPass($board2, $to2, $player2, $hand2),
                "This player can't pass"
            );
            $this->assertTrue(
                canPass($board3, $to3, $player3, $hand3),
                'this player can pass.'
            );
        }

        public function testGameEnd(){
            $board = [
                '0,0' => [[0, 'Q']],
                '0,-1' => [[1, 'Q']],
                '1,-1' =>[[1, 'S']],
                '1,0' =>[[1, 'B']],
                '0,1' =>[[1,'A']],
                '-1,1' =>[[1,'A']],
                '-1,0' =>[[1,'A']],
            ];
            $expected[] = 1;
            $result = gameEnd($board);
            $this->assertEquals($expected[0], $result[0], 'Player 1 has won this round '.$result[0]);
            $board = [
                '0,0' => [[1, 'Q']],
                '0,-1' => [[0, 'Q']],
                '1,-1' =>[[0, 'S']],
                '1,0' =>[[0, 'B']],
                '0,1' =>[[0,'A']],
                '-1,1' =>[[0,'A']],
                '-1,0' =>[[0,'A']],
            ];
            $expected[0] = 0;
            $result = gameEnd($board);
            $this->assertEquals($expected, $result, 'Player 0 has won this round');
        }

    }
