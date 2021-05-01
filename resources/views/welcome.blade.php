<!DOCTYPE html>
<head>
    <title>Pusher Test</title>
    <script src="https://js.pusher.com/7.0/pusher.min.js"></script>
    <script>

        // Enable pusher logging - don't include this in production
        Pusher.logToConsole = true;

        var pusher = new Pusher('81c1a4f007c70f9311b9', {
            cluster: 'eu'
        });

        var channel = pusher.subscribe({{$topic}});
        channel.bind('my-event', function(data) {
            alert(JSON.stringify(data));

         });
    </script>
</head>
<body>
<h1>Pusher Test</h1>
<p>
    Try publishing an event to channel <code>my-channel</code>
    with event name <code>my-event</code>.
    JSON.stringify(data)
</p>
</body>
