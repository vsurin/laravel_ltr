<template>
    <div>
        <div class="row">
            <div class="col-lg-12 margin-tb">
                <div class="pull-right">
                    <a class="btn btn-primary" v-bind:href="linkPdf">Generate PDF</a>
                </div>
            </div>
        </div>

        <div class="col-xs-12 col-sm-12 col-md-12">
            <div>
                <label>Title:</label>
                {{ project.title }}
            </div>
            <div>
                <label>Organization:</label>
                {{ project.organization }}
            </div>
            <div>
                <label>Start:</label>
                {{ project.start }}
            </div>
            <div>
                <label>End:</label>
                {{ project.end }}
            </div>
            <div>
                <label>Role:</label>
                {{ project.role  }}
            </div>
            <div>
                <label>Link:</label>
                {{ project.link }}
            </div>
            <div>
                <label>Type:</label>
                {{ project.type }}
            </div>
            <div>
                <label>Description:</label>
                {{ project.descrription }}
            </div>
        </div>
    </div>
</template>

<script>
    import axios from 'axios';

    export default {
        props: ['id'],
        data: function() {
            return {
                project: {},
                linkPdf: '/admin/project/generate-pdf/' + this.id,
            }
        },
        mounted: function () {
            this.getProject();
        },
        methods: {
            getProject: function () {
                axios
                    .get('/admin/api/project/show/' + this.id)
                    .then(response => (this.project = response.data.post));
            },
        }
    }
</script>