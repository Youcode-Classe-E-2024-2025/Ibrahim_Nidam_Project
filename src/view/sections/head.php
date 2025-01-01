<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1.0" />
        <meta name="description" content="a knaban app for organizing your tasks and projects" />
        <meta name="keywords" content="kanban,task manager, project manager" />
        <meta name="author" content="Ibrahim Nidam" />
        <title>Kanban</title>

        <!-- <link href="https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css" rel="stylesheet" /> -->
        <script src="https://cdn.tailwindcss.com"></script>
        <!-- <link rel="icon" href="assets/src/images/favicon/favicon-32x32.png" type="image/x-icon" /> -->

        <!-- <link href="../../../../assets/css/tailwind/output.css" rel="stylesheet" /> -->

        <script src="https://code.jquery.com/jquery-3.7.1.js" integrity="sha256-eKhayi8LEQwp4NKxN+CfCh+3qOVUtJn3QNZ0TciWLP4=" crossorigin="anonymous"></script>
        <script src="https://cdn.rawgit.com/harvesthq/chosen/gh-pages/chosen.jquery.min.js"></script>
        <link href="https://cdn.rawgit.com/harvesthq/chosen/gh-pages/chosen.min.css" rel="stylesheet"/>
		<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css" />

        <style>
        
            #handboy
            {
            animation: swing ease-in-out 1.3s infinite alternate;
                transform-origin: 98% 98%;
                transform-box: fill-box;
                
            }


            #girllight
            {
            animation: swing ease-in-out 1.3s infinite alternate;
                transform-origin: 0% 97%;
                transform-box: fill-box;
            }

            #hairgirl
            {
                animation: swinghair ease-in-out 1.3s infinite alternate;
            transform-origin: 60% 0%;
                transform-box: fill-box;
            
            }

            #zero
            {
            transform-origin:bottom;
            transform-box:fill-box;
            
            }

            /*************swing************/
            @keyframes swing {
                0% { transform: rotate(10deg); }
                100% { transform: rotate(-10deg); }
            }

            /*************swing hair************/
            @keyframes swinghair {
                0% { transform: rotate(6deg); }
                100% { transform: rotate(-6deg); }
            }
        </style>

    </head>