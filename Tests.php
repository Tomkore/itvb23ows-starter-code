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
                "Position should be valid for player $player"
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
                '0,1' => [[1, 'Q']]
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

        }

        public function testHasNeighbour(){
            $board = [
                '0,0' => [[0, 'Q']],
                '0,1' => [[1, 'Q']]
            ];
            $player = 0;
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
            $hand=['A', 'A', 'A', 'A', 'A', 'A', 'A', 'Q'];
            $piece = 'Q';
            $player = 0;
            $to = "0,-3";
            $this->assertTrue(
                canPlay($hand, $piece, $player, $board, $to),
                "This is a valid move" . $hand[7] . $_SESSION['error']
            );
        }

    }


?>
