<html lang="en">

<head>
    <title>Home Page</title>
</head>

<body>
    

    <img src="pxp_icon_logo.jpg" height="100" width="300" offset="100,-100" alt="Chicken Finger 12"/>

    <partial name="Breadcrumb"/>
    <h1>Test Site</h1>

    <div class="main-content">
        <p>This is a demostration of Pxp.</p>
    </div>
    <div>
        <p>
            <var name="location" format="str_replace('r','l')"/>
        </p>
        <partial name="UserMenu">
            <arg name="type">Sponge</arg>
        </partial>       


        <widget name="News" id="4522"/>    

        <widget name="HelloWorld"/>
    </div>
    <footer/>
</body>
</html>