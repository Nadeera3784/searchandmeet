<!DOCTYPE html>
<html>
    <head>
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <style>
            *{
                margin: 0;
                padding: 0;
                box-sizing: border-box;
                font-family: sans-serif;
                font-weight: 500;
                line-height: 1.3rem;
            }

            .container{
                width: 100%;
                height: 100%;
                padding: 3rem 0 0 0;
                position: relative;
                display: flex;
                flex-direction: column;
                overflow-y: hidden;
            }
            .container:before,.footer::before {
                content: ' ';
                display: block;
                position: absolute;
                left: 0;
                top: 0;
                width: 100%;
                height: 100%;
                opacity: 0.6;
                background-image: url("/img/assets/Asset 17.png");
                background-repeat: repeat;
                background-size: 50rem;
            }

            .content{
                display: flex;
                flex-direction: column;
                align-items: center;
                background: #fff;
                border-radius: 1rem 1rem 0rem 0rem;
                padding: 5rem 3% ;
                position: relative;
                margin: 0 10%;
            }
            .footer{
                display: flex;
                flex-direction: row;
                justify-content: center;
                background-color: rgba(48, 31, 73,1);
                padding: 5rem  10%;
                position: relative;
                color: white;
                gap: 2rem;
            }

            .foot_sect{
                width: 33%;
            }

            .foot_sect_col{
                display: flex;
                flex-direction: column;
                gap: 1rem;
            }
            .foot_sect_row{
                display: flex;
                flex-direction: row;
                align-items: center;
                gap: 1rem;
            }

            .content_under{
                display: flex;
                flex-direction: column;
                align-items: center;
                background: #eee;
                border-radius: 0rem 0rem 1rem 1rem;
                padding: 3rem 3% ;
                position: relative;
                margin: 0 10%;
            }

            .image{
                position: absolute;
                height:100px;
            }
            .Email_Bg{
                position: absolute;
                width: 98%;
                right: 0;
                top: 2rem;
                z-index: 10;
                pointer-events: none;
                opacity: 60%;
            }

            .welcome{
                display: block;
                text-align: center;
                font-size: 2rem;
                margin-top:8rem;
                margin-bottom: 2rem;
                line-height: 2.2rem;
            }

            .welcome span{
                font-weight: bold !important;
                color:  rgba(234, 31, 73, 1);
            }
            .second_text{
                display: block;
                text-align: center;
                font-size: 1rem;
                width: 60%;

            }
            .third_text{
                display: block;
                text-align: center;
                font-size: 0.8rem;
                width: 60%;
                margin-top: 2rem;
            }
            .btn{
                font-size: 1rem;
                padding: 0.5rem 1rem;
                cursor: pointer;
                border: none;
                border-radius: 0.4rem;
                background-color: rgba(234, 31, 73, 1);
                color: white;
            }

            .btn:hover{
                background-color: rgb(219, 31, 69);
            }

            @media screen and (max-width: 600px) {
                .content,.content_under{
                    margin: 0 5%;
                }
                .image{
                    height:70px;
                }

                .third_text,
                .second_text
                {
                    width: 80%;
                }
                .welcome{
                    margin-top:6rem;
                }

                .Email_Bg{
                    display: none;
                }
                .footer{
                    display: flex;
                    flex-direction: column;
                    align-items: flex-start;
                }
                .foot_sect{
                    width: 100%;
                }
            }
        </style>
    </head>
    <body>
        <div class="container bg-purple-500">
            <div style="overflow: hidden; height: max-content;">
                <div style="" class="content">
                    <img class="image" src="/img/Search-Meetings-Logo.png">
                    <img class="Email_Bg" src="/img/Email_Bg.png">
                    <h1 style="" class="welcome">Welcome, <span>John Doe</span></h1>
                    <p class="second_text">
                        Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat.
                    </p>
                </div>
                <div style="" class="content_under">
                    <p class="second_text">
                        Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et.
                    </p>
                    <br>
                    <button class="btn">
                        Confirm and proceed
                    </button>
                    <p class="third_text">
                        Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.
                    </p>
                </div>
            </div>
            <div style="margin-top:3rem;" class="footer">
                <div class="foot_sect">
                    <img src="/img/Logo-White.png" style="width: 10rem; margin-bottom: 1rem;" alt="">
                    <div class=" ">Copyright &copy; Search Meetings Inc. <br>All rights reserved.</div>
                </div>
                <div class="foot_sect">
                    <p style="font-weight: 700;">Digital Media Solutions Australia</p>
                    <br>Office 17, 4 Floor, Collins Arch, 447
                    Collins Street, Melbourne VIC 3000
                    Australia.
                    <br>
                    <br>
                        +61 444 587 719
                </div>
                <div class=" foot_sect_col">
                    <p class="">Social Media</p>
                    <div class=" foot_sect_row">
                        <a href="https://www.facebook.com/searchmeetings">
                            <svg xmlns="http://www.w3.org/2000/svg" style="width: 1.5rem; height : 1.5rem; color: white;" viewBox="0 0 34.875 34.664">
                                <path id="Icon_awesome-facebook" data-name="Icon awesome-facebook" d="M35.438,18A17.438,17.438,0,1,0,15.275,35.227V23.041h-4.43V18h4.43V14.158c0-4.37,2.6-6.784,6.586-6.784a26.836,26.836,0,0,1,3.9.34V12h-2.2a2.52,2.52,0,0,0-2.841,2.723V18h4.836l-.773,5.041H20.725V35.227A17.444,17.444,0,0,0,35.438,18Z" transform="translate(-0.563 -0.563)" fill="#fff"/>
                            </svg>
                        </a>
                        <a href="https://www.linkedin.com/showcase/74128398/admin/">
                            <svg xmlns="http://www.w3.org/2000/svg" style="width: 1.5rem; height : 1.5rem; color: white;" viewBox="0 0 56 56">
                                <path id="Exclusion_1" data-name="Exclusion 1" d="M28,56A28.007,28.007,0,0,1,17.1,2.2,28.007,28.007,0,0,1,38.9,53.8,27.824,27.824,0,0,1,28,56Zm6.831-29.057c3.4,0,3.4,3.219,3.4,5.569V42.75H44.75V31.2c0-5.2-.948-10.006-7.825-10.006a6.9,6.9,0,0,0-6.179,3.4h-.092V21.719H24.392V42.75h6.523V32.336C30.915,29.669,31.38,26.943,34.831,26.943ZM13.77,21.719V42.75H20.3V21.719ZM17.033,11.25a3.8,3.8,0,1,0,3.782,3.783A3.787,3.787,0,0,0,17.033,11.25Z" transform="translate(0 0)" fill="#fff"/>
                            </svg>
                        </a>
                        <a href="https://twitter.com/searchmeetings?s=11">
                            <svg xmlns="http://www.w3.org/2000/svg" style="width: 1.5rem; height : 1.5rem; color: white;" viewBox="0 0 60 60">
                                <path id="Exclusion_2" data-name="Exclusion 2" d="M30,60A30.008,30.008,0,0,1,18.323,2.358,30.008,30.008,0,0,1,41.677,57.643,29.813,29.813,0,0,1,30,60ZM12.348,42.394h0a21.762,21.762,0,0,0,11.8,3.448C37.828,45.842,46,34.728,46,23.983c0-.327,0-.666-.024-1a16.42,16.42,0,0,0,3.854-3.973A15.341,15.341,0,0,1,45.41,20.2a7.66,7.66,0,0,0,3.378-4.234,15.216,15.216,0,0,1-4.876,1.856,7.69,7.69,0,0,0-13.3,5.256,8.608,8.608,0,0,0,.191,1.76A21.889,21.889,0,0,1,14.963,16.8a7.693,7.693,0,0,0,2.379,10.275,7.757,7.757,0,0,1-3.473-.975v.1a7.716,7.716,0,0,0,6.161,7.54A8.17,8.17,0,0,1,18.008,34a9.646,9.646,0,0,1-1.451-.119,7.7,7.7,0,0,0,7.183,5.328A15.311,15.311,0,0,1,14.2,42.488,15.778,15.778,0,0,1,12.348,42.394Z" transform="translate(0 0)" fill="#fff"/>
                            </svg>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </body>
</html>
