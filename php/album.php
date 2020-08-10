<?php
session_start();
$_SESSION['current'] = 'album.php';

include "dbcon.php";
?>

<button class="material-icons back" onclick="$('#browse-page').click()">arrow_back_ios</button>

<div id="album-area">
    <img id="album-picture" src="<?=$_COOKIE["album_loc"] ?>">
        <div id="profile">
            <p id="album-album-name"><?=$_COOKIE["album_name"] ?></p>
            <p id="album-artist-name">By <?=$_COOKIE["artist_name"] ?></p>
        </div>
    </div>
    
    <!-- DATA CELLS -->
    <div id="datacells">
        <div id="datacells-heading">
            <span class="track-number">#</span>
            <span class="track-number track-fav"></span>
            <span class="track-title">TITLE</span>
            <span class="track-artist">ARTIST</span>
        </div>
    
        <!-- Albums Gallery -->
    
            <?php
$con = OpenCon();

if ($stmt = $con->prepare('SELECT tracks.track_id, tracks.track_title, tracks.track_loc, albums.album_name, albums.album_loc, artists.artist_name, artists.artist_loc FROM tracks INNER JOIN albums INNER JOIN albumsxartists INNER JOIN artists on tracks.album_id = albums.album_id AND albums.album_id = albumsxartists.album_id AND albumsxartists.artist_id = artists.artist_id AND albums.album_name = ?')) {
    $stmt->bind_param('s', $_COOKIE["album_name"]);
    $stmt->execute();

    $result = $stmt->get_result();

    $count = 0;
    while ($row = $result->fetch_assoc()) {
        echo <<<EOL
            <div class="datacells-tracks">
                <button class="material-icons track-number track-number-a" data-count={$count} onclick="loadTrack('{$row["track_loc"]}', '{$row["artist_name"]}', '{$row["track_title"]}', '{$row["album_loc"]}', {$count})">play_circle_filled</button>
            EOL;
        $con =  OpenCon();
        if ($stmt1 = $con->prepare("SELECT COUNT(*) FROM userxlikes where user_id = ? and track_id = ?")) {
            $stmt1->bind_param("ii", $_SESSION["id"], $row["track_id"]);
            $stmt1->execute();
            $stmt1->bind_result($found);

            $stmt1->fetch();
                
            if ($found == 0) {
                echo <<<EOL
                    <button class="material-icons favorite favorite-a" data-id='{$row["track_id"]}' onclick="favorite('{$row["track_id"]}')")">favorite_border</button>
                    EOL;
            } else {
                echo <<<EOL
                        <button class="material-icons favorite favorite-a" data-id='{$row["track_id"]}' onclick="favorite('{$row["track_id"]}')")">favorite</button>
                    EOL;
            }
        }
        echo <<< EOL
                    <span class="track-title track-title-a">{$row["track_title"]}</span>
                    <span class="track-artist track-artist-a" onclick="artistNav('{$row["artist_name"]}', '{$row["artist_loc"]}', 1)">{$row["artist_name"]}</span>
                </div>
            EOL;
        $count++;
    }
}
?>
        </div>
</div>
