<x-app-layout>

    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Clientes
        </h2>
    </x-slot>
    <div id="app">

        <x-container class="py-8">

            {{-- crear clientes --}}
            <x-form-section class="mb-12">



                {{-- mostrar clientes --}}

                <x-slot name="title">
                    Lista de Clientes
                </x-slot>

                <x-slot name="description">
                    Clientes dado de alta
                </x-slot>

            </x-form-section>


            <div v-for="item in info">
                <div
                    class="max-w-sm bg-white border border-gray-200 rounded-lg shadow dark:bg-gray-800 dark:border-gray-700">
                    <a href="#">
                        <img class="rounded-t-lg" :src="'https://www.dailymotion.com/thumbnail/video/' + item.id"
                            alt="" />
                    </a>
                    <div class="p-5">
                        <a href="#">
                            <h5 class="mb-2 text-2xl font-bold tracking-tight text-gray-900 dark:text-white">
                                @{{ item.title }}</h5>
                        </a>
                        {{--    <p class="mb-3 font-normal text-gray-700 dark:text-gray-400">Here are the biggest enterprise technology acquisitions of 2021 so far, in reverse chronological order.</p> --}}
                        {{--   <a href="#" class="inline-flex items-center px-3 py-2 text-sm font-medium text-center text-white bg-blue-700 rounded-lg hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">
                    Read more
                    <svg aria-hidden="true" class="w-4 h-4 ml-2 -mr-1" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" d="M10.293 3.293a1 1 0 011.414 0l6 6a1 1 0 010 1.414l-6 6a1 1 0 01-1.414-1.414L14.586 11H3a1 1 0 110-2h11.586l-4.293-4.293a1 1 0 010-1.414z" clip-rule="evenodd"></path></svg>
                </a> --}}
                    </div>
                </div>

            </div>

            <div v-for="dale in clima">
                @{{dale}}
            </div>




        </x-container>


        {{-- Modal edit --}}
        <x-dialog-modal modal="editForm.open">
            <x-slot name="title">
                Editar Cliente
            </x-slot>

            <x-slot name="content">
                {{--  --}}
                <div class="space-y-6">

                    <div class="">
                        <x-input-label>
                            Nombre
                        </x-input-label>
                        <x-text-input v-model="editForm.name" type="text" class="w-full mt-1" />
                    </div>
                    <div class="">
                        <x-input-label>
                            URL de redirección
                        </x-input-label>
                        <x-text-input v-model="editForm.redirect" type="text" class="w-full mt-1 mb-6" />

                    </div>


                </div>

            </x-slot>

            <x-slot name="footer">
                <button type="button" v-on:click="update()" v-bind:disabled="editForm.disabled"
                    class="w-full inline-flex justify-center rounded-md border border-transparent shadow-sm px-4 py-2 bg-red-600 text-base font-medium text-white hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500 sm:ml-3 sm:w-auto sm:text-sm disabled:opacity-50">
                    Actualizar
                </button>



                <button v-on:click="editForm.open = false" type="button"
                    class="mt-3 w-full inline-flex justify-center rounded-md border border-gray-300 shadow-sm px-4 py-2 bg-white text-base font-medium text-gray-700 hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 sm:mt-0 sm:ml-3 sm:w-auto sm:text-sm">
                    Cancelar
                </button>
            </x-slot>


        </x-dialog-modal>

        {{-- Modal show --}}
        <x-dialog-modal modal="showClient.open">
            <x-slot name="title">
                Mostrar credenciales
            </x-slot>

            <x-slot name="content">
                <div class="space-y-2">

                    <p>
                        <span class="font-semibold">CLIENTE: </span>
                        <span v-text="showClient.name"></span>
                    </p>

                    <p>
                        <span class="font-semibold">CLIENT_ID: </span>
                        <span v-text="showClient.id"></span>
                    </p>

                    <p>
                        <span class="font-semibold">CLIENT_SECRET: </span>
                        <span v-text="showClient.secret"></span>
                    </p>

                </div>
            </x-slot>

            <x-slot name="footer">
                <button v-on:click="showClient.open = false" type="button"
                    class="w-full inline-flex justify-center rounded-md border border-transparent shadow-sm px-4 py-2 bg-red-600 text-base font-medium text-white hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500 sm:ml-3 sm:w-auto sm:text-sm disabled:opacity-50">
                    Cancelar
                </button>
            </x-slot>

        </x-dialog-modal>




    </div>

    {{-- aca arrancamos vue --}}

    @push('js')
        <script>
            new Vue({
                el: '#app',
                data: {
                    clients: [],
                    info: [],
                    clima: [],

                    showClient: {
                        open: false,
                        name: false,
                        id: null,
                        secret: null,
                    },
                    createForm: {
                        disabled: false,
                        errors: [],
                        name: null,
                        redirect: null,
                    },
                    editForm: {
                        open: false,
                        disabled: false,
                        errors: [],
                        id: null,
                        name: null,
                        redirect: null,
                    }

                },

                mounted() {
                    this.getClients();

                    axios.get("https://api.dailymotion.com/videos?channel=news&limit=10")
                        .then(response => {
                            this.info = response.data.list
                        });
/* 
                    axios.get("https://api.weatherbit.io/v2.0/current?lat=35.7796&lon=-78.6382&key=f2207d043ea74a359ff232a1d03d0c72&include=minutely")  */
                    axios.get("https://api.openweathermap.org/2.5/wheater?q=BURNOS AIRESlat=35.7796&lon=-78.6382&key=f2207d043ea74a359ff232a1d03d0c72&include=minutely")   

                              
                        .then(response => {
                            this.clima = response
                        });
                },
                methods: {
                    getClients() {
                        axios.get('/oauth/clients')
                            .then(response => {
                                this.clients = response.data
                            });
                    },
                    show(client) {
                        this.showClient.open = true;
                        this.showClient.id = client.id;
                        this.showClient.name = client.name;
                        this.showClient.secret = client.secret
                    },
                    store() {
                        this.createForm.disabled = true;

                        axios.post('/oauth/clients', this.createForm)
                            .then(response => {
                                this.createForm.name = null;
                                this.createForm.redirect = null;

                                /* aca hacemos que ni bien se de alta se abra el modal mostrando los registros importantes */
                                this.show(response.data)


                                this.getClients();
                                this.createForm.disabled = false;
                            }).catch(error => {
                                Swal.fire({
                                    icon: 'error',
                                    title: 'Oops...',
                                    text: 'Los Campos son obligatorios',

                                })
                                /*  this.createForm.errors = _.flatten(_.toArray(error.response.data.errors)); */

                                this.createForm.disabled = false;

                            })
                    },

                    edit(client) {
                        this.editForm.open = true;
                        this.editForm.id = client.id;
                        this.editForm.name = client.name;
                        this.editForm.redirect = client.redirect;

                    },

                    update() {

                        this.editForm.disabled = true;

                        axios.put('/oauth/clients/' + this.editForm.id, this.editForm)
                            .then(response => {
                                this.editForm.name = null;
                                this.editForm.redirect = null;

                                Swal.fire({
                                    position: 'top-center',
                                    icon: 'success',
                                    title: 'Modificación Generada',
                                    showConfirmButton: false,
                                    timer: 1800
                                })
                                this.getClients();
                                this.editForm.disabled = false;
                                this.editForm.open = false;
                            }).catch(error => {

                                Swal.fire({
                                    icon: 'error',
                                    title: 'Oops...',
                                    text: 'Los Campos son obligatorios',
                                })
                                this.editForm.disabled = false;

                            })
                    },

                    destroy(client) {
                        Swal.fire({
                            title: 'Estas seguro/a',
                            text: "¡No podrás revertir esto!",
                            icon: 'warning',
                            showCancelButton: true,
                            confirmButtonColor: '#2563eb',
                            cancelButtonColor: '#d33',
                            confirmButtonText: 'Si, Elimina esto!'
                        }).then((result) => {
                            if (result.isConfirmed) {

                                axios.delete('/oauth/clients/' + client.id)
                                    .then(response => {
                                        this.getClients();

                                    });

                                Swal.fire(
                                    'Eliminado!',
                                    'Su archivo fue eliminado.',
                                    'success'
                                )
                            }
                        })
                    }


                }
            });
        </script>
    @endpush

</x-app-layout>
