<?php

echo 'Hi '.Auth::user()->first_name.Auth::user()->last_name.' ('.Auth::user()->email.')';