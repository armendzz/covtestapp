
<x-app-layout>
    <div class="pb-5 px-5 ">
      <div class="d-flex justify-content-between mt-2 mb-2">
        <form action="/positiveformsend/{{$test->id}}" method="post">
            @method('put')
        @csrf
        <input type="hidden" name="filename" value="{{$filename}}">
        <input type="hidden" name="gname" value="{{$gname}}">
        <input type="hidden" name="gemail" value="{{$gemail}}">
        <button type="submit" class="btn btn-lg btn-success">Gesundheitsamt Anmelden</button>
        </form>
      </div>
        <div class="card">
          <embed
          src="/{{$filename}}"
          type="application/pdf"
          frameBorder="0"
          scrolling="no"
          height="1200px"
          width="100%"
      ></embed>
        </div>
    </div>
    <div>
     
    </div>
    </x-app-layout>
    
  