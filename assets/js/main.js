'use strict';

let svidia_video;
let svidia_display;
let svidia_progressbar;

function idvp_humanizeTime(time, duration){
    let x;
    let seconds;
    let minutes;
    let hours;
    x = Math.floor(time);
    if (Math.floor(x % 60) < 10) {
        seconds = '0' + Math.floor(x % 60);
    } else {
        seconds = Math.floor(x % 60);
    }
    x /= 60;
    if (Math.floor(x % 60) < 10) {
        minutes = '0' + Math.floor(x % 60);
    } else {
        minutes = Math.floor(x % 60);
    }
    x /= 60;
    if (Math.floor(x % 24) < 10) {
        hours = '0' + Math.floor(x % 24);
    } else {
        hours = Math.floor(x % 24);
    }

    console.log(Math.floor(duration));

    if (duration > 3599) {
        return hours + ':' + minutes + ':' + seconds;
    } else {
        return minutes + ':' + seconds;
    }
}

function idvp_open_settings(id){
    let player = document.querySelector('.idvp_svidia_player_container[data-idvplayer-container="' + id + '"]');

    document.querySelector('.idvp_svidia_player_container[data-idvplayer-container="' + id + '"] .idvp_player_menu_layer.main_menu').setAttribute('style', 'display: flex;');

    document.querySelector('.idvp_svidia_player_container[data-idvplayer-container="' + id + '"] .idvp_player_menu_layer.main_menu .idvp_player_menu_bg').onclick = function(){
        document.querySelector('.idvp_svidia_player_container[data-idvplayer-container="' + id + '"] .idvp_player_menu_layer.main_menu').setAttribute('style', 'display: none;');
    }
}

function idvp_open_about_player(id){
    document.querySelector('.idvp_svidia_player_container[data-idvplayer-container="' + id + '"] .idvp_player_menu_layer.main_menu').setAttribute('style', 'display: none;');
    document.querySelector('.idvp_svidia_player_container[data-idvplayer-container="' + id + '"] .idvp_player_menu_layer.about_window').setAttribute('style', 'display: flex;');

    document.querySelector('.idvp_svidia_player_container[data-idvplayer-container="' + id + '"] .idvp_player_menu_layer.about_window .idvp_player_menu_bg').onclick = function(){
        document.querySelector('.idvp_svidia_player_container[data-idvplayer-container="' + id + '"] .idvp_player_menu_layer.about_window').setAttribute('style', 'display: none;');
    }
}

function idvp_showControls(id){
    let player = document.querySelector('.idvp_svidia_player_container[data-idvplayer-container="' + id + '"]');
    let timer;
    let timeout = function () {
        player.classList.remove('mousemove');
    }
    timer = setTimeout(timeout, 0);
    player.onmousemove = function() {
        player.classList.add('mousemove');
        clearTimeout(timer);
        timer = setTimeout(timeout, 500);
    };
}

function idvp_play(id){
    let player = document.querySelector('.idvp_svidia_player[data-svidia-id="' + id + '"]');
    let player_container = document.querySelector('.idvp_svidia_player_container[data-idvplayer-container="' + id + '"]');
    player.play();
    player.volume = 0.7;
    document.querySelector('.idvp_svidia_player_btn_play[onclick="idvp_play(' + id + ')"]').style.display = 'none';
    document.querySelector('.idvp_svidia_player_btn_pause[onclick="idvp_pause(' + id + ')"]').style.display = 'inline-block';
    player.addEventListener('timeupdate', (event) => {
        let duration = player.duration;
        let current = player.currentTime;
        let videoFullDuration = player.duration;
        let currentTimeProgress = idvp_humanizeTime(player.currentTime, player.duration);
        document.querySelector('.idvp_video_progress_bar[data-svidia-id="' + id + '"]').value = (100 * current) / duration;
        document.querySelector('.idvp_svidia_player_container[data-idvplayer-container="' + id + '"] .idvp_playert_start_time').innerHTML = currentTimeProgress;
    });
    player_container.classList.remove('not_played');
}

function idvp_pause(id){
    let player = document.querySelector('.idvp_svidia_player[data-svidia-id="' + id + '"]');
    let player_container = document.querySelector('.idvp_svidia_player_container[data-idvplayer-container="' + id + '"]');
    player.pause();
    document.querySelector('.idvp_svidia_player_btn_pause[onclick="idvp_pause(' + id + ')"]').style.display = 'none';
    document.querySelector('.idvp_svidia_player_btn_play[onclick="idvp_play(' + id + ')"]').style.display = 'inline-block';
    player_container.classList.add('not_played');
}

function idvp_stop(id){
    let player = document.querySelector('.idvp_svidia_player[data-svidia-id="' + id + '"]');
    let player_container = document.querySelector('.idvp_svidia_player_container[data-idvplayer-container="' + id + '"]');
    player.pause();
    player.currentTime = 0;
    document.querySelector('.idvp_svidia_player_btn_play[onclick="idvp_play(' + id + ')"]').style.display = 'inline-block';
    document.querySelector('.idvp_svidia_player_btn_pause[onclick="idvp_pause(' + id + ')"]').style.display = 'none';
    player_container.classList.add('not_played');
}

function idvp_speedReset(id){
    let player = document.querySelector('.idvp_svidia_player[data-svidia-id="' + id + '"]');
    player.playbackRate = 1;
    document.querySelector('.idvp_player_svidia_speedup[data-svidia-id="' + id + '"] .idvp_svidia_speedup_button.idvp_active').classList.remove('idvp_active');
    document.querySelector('.idvp_svidia_player_btn_speedreset[onclick="idvp_speedReset(' + id + ')"]').classList.add('idvp_active');
}

function idvp_speedUp(id){
    let player = document.querySelector('.idvp_svidia_player[data-svidia-id="' + id + '"]');
    player.playbackRate = 1.25;
    document.querySelector('.idvp_player_svidia_speedup[data-svidia-id="' + id + '"] .idvp_svidia_speedup_button.idvp_active').classList.remove('idvp_active');
    document.querySelector('.idvp_svidia_player_btn_speedup[onclick="idvp_speedUp(' + id + ')"]').classList.add('idvp_active');
}

function idvp_speedUpMore(id){
    let player = document.querySelector('.idvp_svidia_player[data-svidia-id="' + id + '"]');
    player.playbackRate = 1.5;
    document.querySelector('.idvp_player_svidia_speedup[data-svidia-id="' + id + '"] .idvp_svidia_speedup_button.idvp_active').classList.remove('idvp_active');
    document.querySelector('.idvp_svidia_player_btn_speedupmore[onclick="idvp_speedUpMore(' + id + ')"]').classList.add('idvp_active');
}

function idvp_speedUpMax(id){
    let player = document.querySelector('.idvp_svidia_player[data-svidia-id="' + id + '"]');
    player.playbackRate = 2;
    document.querySelector('.idvp_player_svidia_speedup[data-svidia-id="' + id + '"] .idvp_svidia_speedup_button.idvp_active').classList.remove('idvp_active');
    document.querySelector('.idvp_svidia_player_btn_speedupmaximum[onclick="idvp_speedUpMax(' + id + ')"]').classList.add('idvp_active');
}

function idvp_videoVolume(id){
    let player = document.querySelector('.idvp_svidia_player[data-svidia-id="' + id + '"]');
    let v = document.querySelector('.idvp_svidia_player_volume[oninput="idvp_videoVolume(' + id + ')"]').value;
    player.volume = v / 100;
}

// function progressUpdate(){
//     let duration = svidia_video.duration;
//     let current = svidia_video.currentTime;
//     svidia_progressbar.value = (100 * current) / duration;
// }

function idvp_videoewind(id){
    let player = document.querySelector('.idvp_svidia_player[data-svidia-id="' + id + '"]');
    let progressbar = document.querySelector('.idvp_video_progress_bar[data-svidia-id="' + id + '"]');
    let width = progressbar.offsetWidth;
    let offset = event.offsetX;
    let duration = player.duration;
    progressbar.value = 100 * offset / width;
    player.currentTime = duration * (offset / width);
}

function idvp_fullscreen(id){
    let player_container = document.querySelector('.idvp_svidia_player_container[data-idvplayer-container="' + id + '"]');
    let player = document.querySelector('.idvp_svidia_player[data-svidia-id="' + id + '"]');
    document.onkeyup = function(event){
        if (event.keyCode == 32) {
            if (player.paused) {
                event.preventDefault();
                player.play();
                player.addEventListener('timeupdate', (event) => {
                    let duration = player.duration;
                    let current = player.currentTime;
                    document.querySelector('.idvp_video_progress_bar[data-svidia-id="' + id + '"]').value = (100 * current) / duration;
                });
                document.querySelector('.idvp_svidia_player_btn_play[onclick="idvp_play(' + id + ')"]').style.display = 'none';
                document.querySelector('.idvp_svidia_player_btn_pause[onclick="idvp_pause(' + id + ')"]').style.display = 'inline-block';
                player_container.classList.remove('not_played');
            } else {
                player.pause();
                document.querySelector('.idvp_svidia_player_btn_pause[onclick="idvp_pause(' + id + ')"]').style.display = 'none';
                document.querySelector('.idvp_svidia_player_btn_play[onclick="idvp_play(' + id + ')"]').style.display = 'inline-block';
                player_container.classList.add('not_played');
            }
        }
    }
    if (!document.fullscreenElement) {
        player_container.requestFullscreen().catch(err => {
            alert(`Error attempting to enable full-screen mode: ${err.message} (${err.name})`);
        });
    } else {
        document.exitFullscreen();
    }
}