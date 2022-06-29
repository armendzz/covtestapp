
<x-app-layout>
    <div class="pb-5 px-5 ">
      <div class="d-flex justify-content-between mt-2 mb-2">
    
        Test Drucken
     
        <a href="/{{$rechnung->filename}}">Test Herunterladen</a>
      </div>
    
        <div class="card">
          <embed
          src="/{{$rechnung->filename}}"
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
    
  