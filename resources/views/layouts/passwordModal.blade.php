<div class="modal fade" id="passwordModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
    aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Cambio de Contraseña</h5>
                <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="alert alert-warning" role="alert">
                    Recuerde anotar la contraseña en un lugar seguro.
                </div>

                <div class="row" id="contraseñas_div">
                    <div class="col-md-6">
                        <label for="">Nueva contraseña</label>
                        <input type="password" id="nueva" name="nueva" class="form-control" oncopy="return false" onpaste="return false">
                    </div>
                    <div class="col-md-6">
                        <label for="">Confirme contraseña</label>
                        <input type="password" id="confirma" name="confirma" class="form-control" oncopy="return false" onpaste="return false">
                    </div>
                </div>
                <br>
                <div class="alert alert-danger alert-xs" role="alert">
                    La contraseña debe ser mayor a 8 caracteres, contener al menos una letra mayuscula, un numero y un simbolo especial.
                </div>

            </div>
            <div class="modal-footer" id="guardar">
                <button class="btn btn-secondary" type="button" onclick="closeModal()">Cancel</button>
                <button class="btn btn-success" onclick="actualizarPassword()">Guardar</button>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="loadingModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
    aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-body">
                Cargando... <i class="fas fa-spinner fa-spin"></i>
            </div>
        </div>
    </div>
</div>

<script type="text/javascript">

    function closeModal()
    {
        $('#nueva').val('');
        $('#confirma').val('');
        $('#passwordModal').modal('hide');
    }

    function actualizarPassword() 
    {
        var nueva = $('#nueva').val();
        var confirma = $('#confirma').val();
        var expresg = /^(?=.*\d)(?=.*[!@#$%^&*])(?=.*[a-z])(?=.*[A-Z]).{8,25}$/;

        if (nueva === confirma) 
        {
            if (expresg.test(confirma)) 
            {
                $('#loadingModal').modal('show');
                $.ajax({
                    url: "{{ route('actualizarPassword') }}",
                    type: 'post',
                    data:
                    {
                        confirma: confirma,
                        _token: "{{ csrf_token() }}"
                    }
                }).done(function (res){
                    if (res == 'exito')
                    {
                        swal({
                            title: 'Exito!',
                            text: 'Contraseña Actualizada, recuerde anotarla en un lugar seguro.',
                            icon: 'success'
                        });
                        $('#nueva').val('');
                        $('#confirma').val('');
                        $('#passwordModal').modal('hide');
                        $('#loadingModal').modal('hide');
                    } else {
                        swal({
                            title: 'error',
                            text: 'Algo salió mal, intente de nuevo o notifique al administrador.',
                            icon: 'error'
                        });
                    }
                })
            } else {
                swal({
                    title: 'error',
                    text: 'La contraseña debe ser mayor a 8 caracteres, contener al menos una letra mayuscula, un numero y un simbolo especial.',
                    icon: 'error'
                });
            }
        } else {
            swal({
                title: 'error',
                text: 'Contraseñas no coinciden.',
                icon: 'error'
            });
        }
    }

</script>
