<div class="modal fade" id="modal-member" tabindex="-1" role="dialog" aria-labelledby="modal-member">
    <div class="modal-dialog modal-xl" role="document">
        <div class="modal-content">
            <div class="modal-header">
              <h4 class="modal-title">Pilih Member</h4>
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>
            </div>
            <div class="modal-body">
              <table class="table table-striped table-bordered table-supplier table-produk">
                <thead>
                    <th class="text-center" width="5%">No</th>
                    <th class="text-center">Kode</th>
                    <th class="text-center">Poin</th>
                    <th class="text-center">Nama</th>
                    <th class="text-center">Email</th>
                    <th class="text-center">Gender</th>
                    <th class="text-center">Phone</th>
                    <th class="text-center">Alamat</th>
                    <th class="text-center">Keterangan</th>
                    <th class="text-center"><i class="fa fa-cog"></i></th>
                </thead>
                <tbody>
                  @foreach ($member as $item)
                    <tr>
                      <td class="text-center" width="5%">{{ $loop->iteration }}</td>
                      <td class="text-center"><span class="badge badge-success">{{ $item->code }}</span></td>
                      <td>{{ $item->poin }}</td>
                      <td>{{ $item->name }}</td>
                      <td>{{ $item->email }}</td>
                      <td class="text-center">
                        @if (($item->gender) === 1)
                          <span class="badge badge-danger">Laki-laki</span>
                        @elseif (($item->gender) === 2)
                          <span class="badge badge-primary">Perempuan</span>
                        @endif
                      </td>
                      <td>{{ $item->phone }}</td>
                      <td>{{ $item->address }}</td>
                      <td>{{ $item->description }}</td>
                      <td>
                        <a href="#" class="modal-pilih-member btn btn-primary btn-xs" onclick="pilihMember('{{ $item->id }}', '{{ $item->code }}', '{{ $item->name }}')" data-dismiss="modal">
                          <i class="fa fa-check-circle"></i>
                          Pilih
                        </a>
                      </td>
                    </tr>
                  @endforeach                  
                    
                </tbody>
              </table>
            </div>
        </div>
    </div>
</div>