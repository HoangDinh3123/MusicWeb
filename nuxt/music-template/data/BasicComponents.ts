const UiSidebar = [
    {
        id: 1,
        icon: 'ic:baseline-play-circle',
        name: 'Discover',
        path: '/'
    },
    {
        id: 2,
        icon: 'ic:round-format-align-left',
        name: 'Browse',
        path: '/browse'
    },
    {
        id: 3,
        icon: 'ic:baseline-account-box',
        name: 'Artist',
        path: '/artist/artist'
    },
    {
        id: 4,
        icon: 'ic:baseline-search',
        name: 'Search',
        search: 'true'
    },
    {
        id: 5,
        icon: 'ic:baseline-format-list-bulleted',
        name: 'Tracks',
        test: true
    },
    {
        id: 6,
        icon: 'ic:outline-playlist-play',
        name: 'Playlists',
    },
    {
        id: 7,
        icon: 'ic:outline-favorite-border',
        name: 'Likes',
    },
]

const songs = [
    {
        name: 'Đấng nam nhi',
        artist: 'Thái Học',
        src: '_nuxt/assets/mp3/vwdtiivpyz.mp3'
    },
    {
        name: 'Tự nhiên',
        artist: 'Hồ Ngọc Hà',
        src: '_nuxt/assets/mp3/TuNhien-HoNgocHa-14315745.mp3'
    },
    {
        name: 'Thiên lý ơi',
        artist: 'Jack',
        src: '_nuxt/assets/mp3/ThienLyOi-JackJ97-13829746.mp3'
    },
    {
        name: 'Ngược chiều yêu',
        artist: 'Đỗ Hoàng Dương',
        src: '_nuxt/assets/mp3/NguocChieuYeu-DoHoangDuong-14313067.mp3'
    },
    {
        name: 'Đó là dấu ấn',
        artist: 'Orange & LiuGrace',
        src: '_nuxt/assets/mp3/DoLaDauAn-OrangeLiuGrace-14005764.mp3'
    },
    {
        name: 'Cảm ơn vì đã không đợi em',
        artist: 'LyLy',
        src: '_nuxt/assets/mp3/CamOnViDaKhongDoiEm-Lyly-14131482.mp3'
    },
    {
        name: 'Lạc trôi',
        artist: 'Sơn Tùng MTP',
        src: '_nuxt/assets/mp3/LacTroi-SonTungMTP-4725907.mp3'
    },

]

const test = [
    {
        name: 'Ngược chiều yêu',
        artist: 'Đỗ Hoàng Dương',
        src: '_nuxt/assets/mp3/NguocChieuYeu-DoHoangDuong-14313067.mp3'
    },
    {
        name: 'Đó là dấu ấn',
        artist: 'Orange & LiuGrace',
        src: '_nuxt/assets/mp3/DoLaDauAn-OrangeLiuGrace-14005764.mp3'
    },
    {
        name: 'Cảm ơn vì đã không đợi em',
        artist: 'LyLy',
        src: '_nuxt/assets/mp3/CamOnViDaKhongDoiEm-Lyly-14131482.mp3'
    },
    
]

const genres = [
    {
        id: 0,
        name: 'All'
    },
    {
        id: 1,
        name: 'Pop'
    },
    {
        id: 2,
        name: 'US/UK'
    },
    
]

const tab = [
    {
        name: 'Bài hát'
    },
    {
        name: 'Thông tin'
    },
    
]

const profileTab = [
    {
        name: 'Tracks'
    },
    {
        name: 'Albums'
    },
    {
        name: 'Playlists'
    },
    {
        name: 'Likes'
    },
    {
        name: 'Profile'
    },
    
]

export{UiSidebar, songs, test, genres, tab, profileTab};