<?php
define('MMW_MEDIA_DIR', 'media/');

// Read Folder
$playlist = array();
if ($dh = opendir(MMW_MEDIA_DIR)) {
    $number = 1;
    while (($file = readdir($dh)) !== false) {
        if (substr($file, -3) !== 'mp3') {
            continue;
        }
        $playlist[] = MMW_MEDIA_DIR . $file;
    }
    closedir($dh);
}
?>
<audio id="mmw-player" controls>
	<source src="<?php echo reset($playlist); ?>" type="audio/mpeg"/>
	<script>
		mmwAudioCurrentTrack = 1;
		mmwAudioPlaylist = <?php echo json_encode($playlist); ?>;
		document.getElementById('mmw-player').addEventListener('ended', function() {
			if (mmwAudioPlaylist.length < 2) {
				return;
			}
			if (window.mmwAudioCurrentTrack >= mmwAudioPlaylist.length) {
				window.mmwAudioCurrentTrack = 0;
			}
			this.src = mmwAudioPlaylist[window.mmwAudioCurrentTrack++];
			this.pause();
			this.load();
			this.play();
		});
	</script>
	<style>
		audio#mmw-player {
			height: 24px;
		}
		audio#mmw-player::-webkit-media-controls-panel {
			background-color: #<?php echo $media_color; ?>;
		}
	</style>
	Your browser does not support HTML5 audio.
</audio>