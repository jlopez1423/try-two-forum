<div class="panel panel-default">

    <div class="panel-heading">
        <div class="level">

            <h5 class="flex">
                <a href="#">
                 {{ $reply->owner->name }}
                </a>
                said {{ $reply->created_at->diffForHumans() }}...

            </h5>

            <div>

                <form method="POST" action="">

                    <button type="submit" class="btn btn-default">Favorite</button>

                </form>

            </div>

        </div>
    </div>

    <div class="panel-body">
                     
        {{ $reply->body }}

    </div>

</div>