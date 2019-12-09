<title>@isset($title)
        {{ $title }}
@endisset</title>

<meta charset="utf-8">

<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
<meta name="description" content=@isset($description) {{ $description }} @endisset />
<meta name="keywords" itemprop="keywords" content="@isset($keywords) {{ $keywords }} @endisset" />
