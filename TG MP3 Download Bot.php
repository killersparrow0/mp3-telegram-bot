<?php
$token = 'BOT_TOKEN';
$img = "BOT_IMG";

$input = file_get_contents('php://input');
$update = json_decode($input);
$send = $update->message->text;
$chat_id = $update->message->chat->id;
$fname = $update->message->chat->first_name;
$lname = $update->message->chat->last_name;

$inlinebutton = [
    'inline_keyboard' => [
        [
            ['text' => "\xF0\x9F\x99\x8B Support Group", 'url' => 'https://t.me/sltechzoneofficial'],
            ['text' => "\xF0\x9F\x94\x94 Update Channel", 'url' => 'https://t.me/sltechzone']
        ],
        [
            ['text' => "\xE2\x9E\x95 Add me to Your Group", 'url' => 'https://t.me/mp3downloadtgbot?startgroup=new']
        ],
    ]
];

$keyboard = json_encode($inlinebutton, true);

if (strpos($send, "/mp3") === 0) {
    $ytsearch = substr($send, 5);
    $ytsearchfinal = str_replace(' ', '_', $ytsearch);
    $ytapi = file_get_contents("https://www.googleapis.com/youtube/v3/search?part=snippet&maxResults=1&q=$ytsearchfinal&type=video&key=YT_API_KEY");
    $ytdecode = json_decode($ytapi, true);
    $id = $ytdecode['items'][0]['id']['videoId'];
    $channelname = $ytdecode['items'][0]['snippet']['channelTitle'];
    $title = $ytdecode['items'][0]['snippet']['title'];
    $publishedat = $ytdecode['items'][0]['snippet']['publishedAt'];
    $imgmp3 = $ytdecode['items'][0]['snippet']['thumbnails']['medium']['url'];

    $inlinebuttonmp3 = [
        'inline_keyboard' => [
            [
                ['text' => "\xF0\x9F\x93\xA5 Download Now \xF0\x9F\x93\xA5", 'url' => "https://www.yt-download.org/public/api/button/mp3/$id"]
            ],
        ]
    ];

    $keyboardmp3 = json_encode($inlinebuttonmp3, true);

    $mp3text = urlencode("<b>\xF0\x9F\x93\x9D Title - $title\n\xF0\x9F\x93\xBA Channel Name - $channelname\n\xF0\x9F\x95\x9C Published Date - $publishedat\n\n\xF0\x9F\x8E\xA7 Telegram MP3 Download Bot \xF0\x9F\x8E\xA7\n~ @mp3downloadtgbot</b>");

    file_get_contents("https://api.telegram.org/bot$token/sendphoto?chat_id=$chat_id&photo=$imgmp3&parse_mode=HTML&caption=$mp3text&reply_markup=$keyboardmp3");
}

if (strpos($send, "/start") === 0) {

    $welcometext = urlencode("<b>\xF0\x9F\x8E\xA7 Telegram MP3 Download Bot \xF0\x9F\x8E\xA7\n\n\xF0\x9F\x91\x8B Hey $fname $lname \xF0\x9F\x92\xAD I'm Telegram MP3 Download Bot i can Download Your MP3 Songs in Second \xF0\x9F\x9A\x80\n\n\xF0\x9F\x92\xAC Just Send me The Song Name You Want to Download\nEx - /mp3 alone\n\n\xE2\x9D\x93 Send /help to Get more Information About Telegram MP3 Download Bot \xE2\x9A\xA1\n\nDeveloped by @hirunaofficial \xf0\x9f\x87\xb1\xf0\x9f\x87\xb0</b>");

    file_get_contents("https://api.telegram.org/bot$token/sendphoto?chat_id=$chat_id&photo=$img&parse_mode=HTML&caption=$welcometext&reply_to_message_id=$msgid&reply_markup=$keyboard");
}

if (strpos($send, "/help") === 0) {

	$helptext = urlencode("<b>\xF0\x9F\x8E\xA7 Telegram MP3 Download Bot \xF0\x9F\x8E\xA7\n\n\xE3\x80\xBD About Bot \xE3\x80\xBD\n\n\xE2\x96\xB6	Name - Telegram MP3 Download Bot\n\xE2\x96\xB6	Username - @mp3downloadtgbot\n\xE2\x96\xB6 Created By - @hirunaofficial\n\n\xF0\x9F\x94\xA7 Bot Commands \xF0\x9F\x94\xA7\n\n\xE2\x96\xB6	/start - Start Telegram MP3 Download Bot\n\xE2\x96\xB6	/help - More information about Telegram MP3 Download Bot\n\xE2\x96\xB6 /mp3 SONG_NAME - Download Your MP3 Songs\nEx - /mp3 alone</b>");
    
	file_get_contents("https://api.telegram.org/bot$token/sendphoto?chat_id=$chat_id&photo=$img&parse_mode=HTML&caption=$helptext&reply_to_message_id=$msgid&reply_markup=$keyboard");
}
