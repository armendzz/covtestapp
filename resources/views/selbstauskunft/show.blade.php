
<x-app-layout>
    <div class="pb-5 px-5 ">
      <div class="d-flex justify-content-between mt-2 mb-2">
    
      Selbstauskunft Drucken
     
        <a href="/{{$selbstauskunft->filename}}">Selbstauskunft Herunterladen</a>
      </div>
    
        <div class="card">
          <embed
          src="/{{$selbstauskunft->filename}}"
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
    
  