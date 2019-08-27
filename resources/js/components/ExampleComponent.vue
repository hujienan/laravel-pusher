<template>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">Exampleddd Component</div>
                    <div class="card-body">
                        I'm an example component.
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    export default {
        created() {
            let channel = window.Echo.channel('my-channel');
            channel.listen('my-event', function(data) {
                console.log(data);
                alert(JSON.stringify(data));
            });
        },
        mounted() {
            console.log('Component mounted.');   
        }
    }
</script>
