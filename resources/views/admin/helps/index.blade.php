@include('admin.layouts.sidebar')

@include('admin.layouts.flashmessage')


    <div class="main-panel">
          
    <div class="col-lg-12 grid-margin stretch-card">
                <div class="card">
                  <div class="card-body">
                    <h4 class="card-title" style="font-size:18px;">Manage Help Page</h4>
                     <a href="{{ route('helps.create') }}"><button type="button" class="btn btn-primary btn-fw">Add Help Page</button></a>
                    

                    <table class="table table-bordered" style="text-align: center; margin-top: 20px;">
                      <thead>
                        <tr>
                          <th> # </th>
                          <th> Title </th>
                          <th> Edit </th>
                          <th> Delete </th>
                          
                        </tr>
                      </thead>
                      <tbody>
                      @php $index =1; @endphp
            @if(!empty($helppagesrecords))
                @foreach($helppagesrecords as $helppagesrecords)
                        <tr>
                          <td> {{$index}} </td>
                          <td> {{$helppagesrecords['name']}} </td>
                          <td>
                            <div class="col-sm-6 col-md-4 col-lg-3" style="max-width: 100%;">
                        <a href="{{ route('helps.edit', ['helpId' => $helppagesrecords['_id'], ]) }}"><button class="btn btn-info align-text-top border-0"><i class="fa fa-edit"></i></button></a>
                      </div>
                          </td>
                          <td>
                             <div class="col-sm-6 col-md-4 col-lg-3" style="max-width: 100%;">
                              <?php if($helppagesrecords['name'] != "Privacy Policy" && $helppagesrecords['name'] != "Terms And Conditions") { ?>
                        <a href="{{ route('helps.delete', ['helpId' => $helppagesrecords['_id'], ]) }}">
                        <button class="btn btn-info align-text-top border-0"><i class="fa fa-trash-o"></i></button>
                      </a>
                              <?php } ?>
                      </div>
                          </td>
                        </tr>
                        @php $index++; @endphp
                @endforeach
                         @else
                        <tr>
                            <td colspan="8">No records found</td>
                        </tr>
                            @endif
                      </tbody>
                    </table>
                        <div class="pagination-wrapper justify-content-center" style="display:grid; margin-top:25px;"> {!! $pagination->render() !!} </div>
                  </div>
                </div>
              </div>
</div>
</div>
@include('admin.layouts.footer')
