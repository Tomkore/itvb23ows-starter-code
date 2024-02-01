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
                antMove("0,-1", $board, "0,3"),
                "this is a valid move for an ant"
            );
            $this->assertFalse(
                antMove("0,-1", $board, "0,4"),
                "this is not a valid antmove"
            );
            $this->assertTrue(
                antMove("0,-1", $board, "1,-1"),
                "this is a valid antmove"
            );
            $this->assertTrue(
                antMove("0,-1", $board, "1,1"),
                "this is a valid antmove"
            );
            $this->assertTrue(
                antMove("0,-1", $board, "-1,1"),
                "this is a valid antmove"
            );
        }

    }
