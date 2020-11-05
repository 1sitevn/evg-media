<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Player demo page</title>

    <link href="./css/docs.min.css" rel="stylesheet"/>
    <link href="./plugins/bootstrap-4.5.3/css/bootstrap.min.css" rel="stylesheet"/>
    <style>
        #myvideo {
            width: 100%;
            text-align: center;
        }

        header {
            margin-bottom: 50px;
        }
    </style>

    <script src="./plugins/jquery/jquery.min.js" type="text/javascript"></script>
    <script src="./plugins/bootstrap-4.5.3/js/bootstrap.min.js" type="text/javascript"></script>
    <script src="./plugins/player/jwplayer-8.17.8/jwplayer.js" type="text/javascript"></script>
</head>
<body>

<header class="navbar navbar-expand navbar-dark flex-column flex-md-row bd-navbar">
    <div class="navbar-nav-scroll">
        <ul class="navbar-nav bd-navbar-nav flex-row">
            <li class="nav-item">
                <a class="nav-link " href="/">Player demo page</a>
            </li>
        </ul>
    </div>
</header>

<?php
$playerOptions = [
    'base' => './plugins/player/jwplayer-8.17.8/',
    'width' => '640',
    'height' => '360',
    'file' => 'https://www.radiantmediaplayer.com/media/rmp-segment/bbb-abr-aes/playlist.m3u8',
    'image' => './plugins/player/assets/preview.jpg',
    'title' => 'Video demo',
    'skin' => [
        'controlbar' => [
            'icons' => '#ffffff',
            'iconsActive' => '#f1c40f'
        ],
        'timeslider' => [
            'progress' => '#f1c40f'
        ]
    ],
    'logo' => [
        'file' => './plugins/player/assets/logo.png',
        'link' => 'https://evgcorp.net',
        'hide' => true,
        'position' => 'control-bar'
    ],
    'abouttext' => 'EVG Player 1.0',
    'aboutlink' => 'https://evgcorp.net'
];

$advs = [];
if (!empty($_GET['adv'])) {
    $advs = $_GET['adv'];

    $playerOptions['advertising'] = [
        'client' => 'vast',
        //'tag' => 'https://playertest.longtailvideo.com/vast-30s-ad.xml',
        //'tag' => './plugins/player/ads/preroll.xml',
        'skipoffset' => 5,
        'skiptext' => 'Bỏ qua',
        'admessage' => 'Quảng cáo sẽ kết thúc sau xx giây',
        'cuetext' => 'Quảng cáo',
        /*'schedule' => [
            'preroll' => [
                'offset' => 'pre',
                'tag' => './plugins/player/ads/preroll.xml'
            ],
            'overlay' => [
                'offset' => 10,
                'tag' => './plugins/player/ads/overlay.xml',
                'type' => 'nonlinear'
            ],
            'midroll' => [
                'offset' => 30,
                'tag' => './plugins/player/ads/midroll.xml',
                'type' => 'linear'
            ]
        ]*/
    ];

    if (in_array('pre-roll', $advs)) {
        $playerOptions['advertising']['schedule']['preroll'] = [
            'offset' => 'pre',
            'tag' => './plugins/player/ads/preroll.xml'
        ];
    }
    if (in_array('overlay', $advs)) {
        $playerOptions['advertising']['schedule']['overlay'] = [
            'offset' => 10,
            'tag' => './plugins/player/ads/overlay.xml',
            'type' => 'nonlinear'
        ];
    }
    if (in_array('mid-roll', $advs)) {
        $playerOptions['advertising']['schedule']['midroll'] = [
            'offset' => 30,
            'tag' => './plugins/player/ads/midroll.xml',
            'type' => 'linear'
        ];
    }
}

?>

<div class="container-fluid">
    <div class="row">
        <div class="col-md-6">
            <form>
                <div class="form-group row">
                    <label class="col-sm-3 col-form-label">Select source</label>
                    <div class="col-sm-9">
                        <select name="player-type" class="form-control">
                            <option value="vod-mp4" selected="selected">VOD MP4</option>
                            <option value="vod-drm">VOD with DRM</option>
                        </select>
                    </div>
                </div>
                <div class="form-group row">
                    <div class="col-sm-3">Advertising settings</div>
                    <div class="col-sm-9">
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" id="advPreRoll"
                                   name="adv[]" <?php echo in_array('pre-roll', $advs) ? 'checked' : '' ?>
                                   value="pre-roll">
                            <label class="form-check-label" for="advPreRoll">
                                Pre-roll
                            </label>
                        </div>
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" id="advOverlay"
                                   name="adv[]" <?php echo in_array('overlay', $advs) ? 'checked' : '' ?>
                                   value="overlay">
                            <label class="form-check-label" for="advOverlay">
                                Overlay
                            </label>
                        </div>
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" id="advMidRoll"
                                   name="adv[]" <?php echo in_array('mid-roll', $advs) ? 'checked' : '' ?>
                                   value="mid-roll">
                            <label class="form-check-label" for="advMidRoll">
                                Mid-roll
                            </label>
                        </div>
                    </div>
                </div>

                <div class="form-group row">
                    <div class="col-sm-10">
                        <button type="submit" class="btn btn-primary">Start test</button>
                    </div>
                </div>
            </form>
        </div>
        <div class="col-md-6">
            <div id='myvideo'></div>
        </div>
    </div>
</div>

<script type='text/javascript'>
    jwplayer.key = "3SYLbRo6MN5cBDxwpZh3dl1gb0lMTUOos31M5hoAlf4=";
    jwplayer('myvideo').setup(<?php echo json_encode($playerOptions) ?>);
</script>
</body>
</html>
