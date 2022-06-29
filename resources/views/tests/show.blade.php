
<x-app-layout>
    <div class="pb-5 px-5 ">
      <div class="d-flex justify-content-between mt-2 mb-2">
        @if (isset($update) && $update)
        <form class="m-2" action="/tests/{{$test->id}}" method="POST" enctype="multipart/form-data">
          @csrf
          @method('PUT')
          <button type="submit" class="btn btn-info">Test mit neuen Daten Aktualisieren</button>
        </form>
          
        @endif
        Test Drucken
        @if( $test->digital == '1') 
        <form action="/emailerneutsenden/{{$test->id}}" method="post">
        @csrf
        <button type="submit" class="btn btn-outline-primary">E-Mail erneut senden</button>
        </form>
        @endif
        <a href="/{{$test->filename}}">Test Herunterladen</a>
      </div>
      @if( $test->digital == '1') 
      <h5 class="text-danger text-center"> <strong>Dieser Test wurde per E-Mail gesendet. Bitte nicht drucken, wenn nicht erwünscht !</strong></h5>
       @endif
        <div class="card">
          <embed
          src="/{{$test->filename}}"
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
    
  