{{-- <div style="position: relative; width:100vw; height:100vh; display:flex; justify-content: center; align-items:start">
    <div style="position: relative; width:50%; display:flex; flex-direction:flex-col; align-items:start">
        <div id="banner_area" class="">
            <img src="{{ $image_banner }}" alt="">
        </div>
        <div style="">
            <p style="text-align: left; color: black; font-size: 14px; font-weight:400">
                Lorem, ipsum dolor sit amet consectetur adipisicing elit. Obcaecati, optio ullam esse cum praesentium, perferendis eligendi ut voluptatem, culpa nesciunt voluptas! Libero facilis corporis quisquam explicabo autem perspiciatis nam eaque.
            </p>
            <p style="text-align: center; margin-left: 20px;">
                <span style="color: gray; font-size: 12px; font-weight: 300">username: ... {{ $image_banner }}</span>
                <span style="color: gray; font-size: 12px; font-weight: 300">password</span>
            </p>
            <div style="display:flex; justify-content:center;">
                <a href="" style="width: 30px; height:20px; font-size:25px; font-weight:400; background-color:dodgerblue; color:white">Login now</a>
            </div>
            <span>Lorem ipsum dolor sit amet consectetur adipisicing elit. Quia praesentium cumque sunt ex eligendi blanditiis nobis adipisci eius et eveniet ea repudiandae, error dicta officiis dignissimos consequuntur beatae, fugit repellat.</span>
        </div>
    </div>
</div> --}}


<div style="height: 100vh; width: 100vw; display: flex; justify-content:center; align-items: center; background-color: #f0f0f0;">

    {{-- Main Card --}}
    <div style="width:30vw; min-width: 300px; padding:20px; border:1px solid #ccc; border-radius: 10px; background-color: #ffffff; box-shadow: 0 4px 5px rgba(0,0,0,0,0.1);">

        <div style="width: 100%; padding: -20px;">
            <div style="width: 100%; height:50px; background-color: #1B4298"></div>
            <div style="width: 100%; height:10px; background-color: #F26531"></div>
        </div>
    
        {{-- Title Card --}}
        <div style="width: 100%; margin-bottom: 15px; margin-top: 15px;  text-align:center;">
            <h2 style="margin: 0; font-size: 20px; font-weight: 600; color: #333;">
                Welcome to CIIS
            </h2>
            <p style="margin:  5px 0 0; font-size: 14px; color: #777;">
                {{ $title }}
            </p>
        </div>

        {{-- Banner Image --}}
        <div style="width: 100%; margin-bottom: 15px;">
            <img src="{{ $image_banner }}" style="width:100%; border-radius:8px;" alt="">
        </div>

        {{-- Text Content --}}
        <p style="text-align: justify; color:#000; font-size: 14px; font-weight: 400; margin-bottom: 10px; padding: 0 5px;">
            Lorem ipsum dolor sit amet consectetur, adipisicing elit. Omnis quae facilis dignissimos numquam officiis placeat accusamus assumenda, eius odit voluptatum ipsum pariatur unde id quisquam ratione inventore. Alias, soluta reiciendis.
        </p>

        {{-- Username --}}
        <p style="margin-left: 25px; margin-bottom:15px;">
            <span style="color:gray; font-size:14px; font-weight: 300px;">Empployee ID: {{ $employee_id }}</span><br>
            <span style="color:gray; font-size:14px; font-weight: 300px;">Password: {{ $password }}</span>
        </p>

        {{-- Login Button --}}
        <div style="display: flex; justify-content: center; margin-bottom: 14px; margin-top: 10px">
            <a href="https://ciis.app/login" style="padding: 8px 16px; font-size:14px; font-weight: 500; background-color: #1B4298; color:white; text-decoration: none; border-radius: 5px;">Login Now</a>
        </div>

        <p style="margin-bottom:15px;">
            <span style="color:gray; font-size:14px; font-weight: 300px;">You may manually access the app through this link: <br>
                <a href="https://ciis.app/login">https://ciis.app/login</a></span>
        </p>

        {{-- Footer Notes --}}
        <p style="font-size: 12px; color: #333; text-align: justify; padding: 0 5px;">
            Lorem ipsum dolor, sit amet consectetur adipisicing elit. Sint, sit! Unde quaerat reprehenderit dolore accusamus nostrum, dolorem dolores delectus nisi dicta, pariatur asperiores, cupiditate perspiciatis omnis architecto rem eaque rerum.
        </p>

        <div style="width: 100%; padding: -20px; margin-top: 15px;">
            <div style="width: 100%; height:10px; background-color: #F26531"></div>
            <div style="width: 100%; height:30px; background-color: #1B4298"></div>
        </div>

    </div>

</div>