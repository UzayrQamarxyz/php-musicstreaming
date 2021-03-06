<?php
session_start();
$_SESSION['current'] = 'browse.php';

include "dbcon.php";
?>
<p id="datagrid-heading">Browse</p>

<!-- DATA CELLS -->
<div id="datacells-browse">
    <!-- Artists Gallery -->

    <div class="gallery-outerdiv">
        <h2 class="gallery-heading">Artists</h2>
        <div class="gallery-innerdiv">

<?php
    $con = OpenCon();
    
    if ($stmt = $con->prepare("SELECT artist_id, artist_name, artist_loc FROM artists;")) {
        $stmt->execute();
        $result = $stmt->get_result();
        
        while ($row = $result->fetch_assoc()) {
            echo <<< EOL
                <div class="album-gallery">
                    <a class="browse-artist" href="#">
                        <img src='{$row["artist_loc"]}' alt="arist" onclick="artistNav('{$row["artist_id"]}','{$row["artist_name"]}', '{$row["artist_loc"]}', 1)" style="border-radius: 50%;">
                    </a>
                    <div class="desc">{$row["artist_name"]}</div>
                </div>
            EOL;
        }
    }
?>

        </div>
    </div>

    <!-- Albums Gallery -->

    <div class="gallery-outerdiv">
        <h2 class="gallery-heading">Albums</h2>
        <div class="gallery-innerdiv">

        <?php
            $con = OpenCon();

            if ($stmt = $con->prepare("SELECT albums.album_id, albums.album_name, albums.album_loc, artists.artist_name from albums JOIN albumsxartists JOIN artists on albums.album_id = albumsxartists.album_id and albumsxartists.artist_id = artists.artist_id")) {
                $stmt->execute();
                $result = $stmt->get_result();

                while ($row = $result->fetch_assoc()) {
                    echo <<< EOL
                        <div class="album-gallery">
                            <a class="browse-album" href="#">
                                <img class="browse-album-select" src="{$row["album_loc"]}" alt="album art" onclick="albumNav('{$row["album_name"]}', '{$row["album_loc"]}', '{$row["artist_name"]}', 1)">
                            </a>
                            <div class="desc">${row["album_name"]}</div>
                        </div>
                    EOL;
                }
            }
        ?>
        </div>
    </div>
</div>
