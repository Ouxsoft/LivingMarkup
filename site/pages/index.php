<html lang="en">

<head>
    <title>Home Page</title>
</head>

<body>
    
    <img src="pxp_icon_logo.jpg" height="100" width="300" offset="100,-100" alt="Chicken Finger 12"/>

    <h1><var name="page_title"/></h1>

    <div class="main-content">
        <p>This is a demostration of Pxp.</p>
    </div>
    <div>
        <partial name="UserMenu"/>
        
        <p><var name="location" format="str_replace('r','l')"/></p>
        
        <widget name="News" id="4522"/>    
        <widget name="News">
            <size>6</size>
        </widget>
    </div>

    <footer/>
</body>
</html>