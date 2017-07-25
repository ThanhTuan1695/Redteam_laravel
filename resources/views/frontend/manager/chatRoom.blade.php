@extends('frontend.layouts.app')
@include('frontend.layouts.sidebar')
@section('content')
    <div class="content" >
        <div class="container " style="float:left; max-width:1300px">
            <div style="height:610px;overflow-x: hiden;overflow-y: auto;word-wrap:break-word;" >
                 <p>Name<span>(Admin)</span></p>
            </div>
            <div class="input-message-container">
                <form action="" method="">
                    <textarea cols="1" rows="1" name="msg" class="form-control" placeholder="Message" 
                    style="width:835px;float:left;resize:none;border-radius:5px"></textarea>
                    <label class="btn btn-default btn-file" style="display:inline; float:left;">
                        Choose File <input type="file" style="display: none;">
                    </label>
                    <button type="submit" class="btn">Submit</button>
                </form>
            </div>
        </div>
    </div>
    
@endsection

