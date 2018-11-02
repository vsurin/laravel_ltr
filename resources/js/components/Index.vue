<template>
    <div>
        <div class="row">
            <div class="col-lg-12 margin-tb">
                <div class="pull-right">
                    <a class="btn btn-primary" href="/admin/projects-vue/create">Add Project</a>
                </div>
            </div>
        </div>

        <div class="row" v-if="isMessage">
            <div class="col-xs-12 col-sm-12 col-md-12">
                <div class="alert alert-success alert-dismissible">
                    <button type="button" class="close" v-on:click="closeMessage">×</button>
                    {{ message }}
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-xs-2  col-sm-2 col-md-2">
                <div><strong>Title</strong></div>
                <input type="text" v-model="title" v-on:input="getProjects(1)">
            </div>
            <div class="col-xs-2  col-sm-2 col-md-2">
                <div><strong>Organization</strong></div>
                <input type="text" v-model="organization" v-on:input="getProjects(1)">
            </div>
            <div class="col-xs-2  col-sm-2 col-md-2">
                <div><strong>Type</strong></div>
                <input type="text" v-model="filterType" v-on:input="getProjects(1)">
            </div>
        </div>

        <table class="table table-bordered">
            <thead>
            <tr>
                <th>ID</th>
                <th>Title</th>
                <th>Organization</th>
                <th>Start</th>
                <th>End</th>
                <th>Role</th>
                <th>Link</th>
                <th>Type</th>
                <th width="280px">Action</th>
            </tr>
            </thead>
            <tbody>
            <tr v-for="(project, key, index) in projects.data">
                <td>{{ project.id }}</td>
                <td>{{ project.title }}</td>
                <td>{{ project.organization }}</td>
                <td>{{ project.start }}</td>
                <td>{{ project.end }}</td>
                <td>{{ project.role }}</td>
                <td>{{ project.type }}</td>
                <td>{{ project.type }}</td>
                <td>
                    <a class="btn btn-info" v-bind:href="'/admin/projects-vue/show/' + project.id" >Show</a>
                    <a class="btn btn-primary" v-bind:href="'/admin/projects-vue/update/'  + project.id">Edit</a>
                    <a class="btn btn-danger" v-on:click="deleteProject(project.id)">Delete</a>
                </td>
            </tr>
            </tbody>
            <tfoot>
            <tr>
                <td colspan="9">
                    <pagination v-model="page" :records="count.data" :per-page="10"  @paginate="getProjects()"></pagination>
                </td>
            </tr>
            </tfoot>
        </table>
    </div>
</template>

<script>
    import axios from 'axios';
    import Pagination from 'vue-pagination-2';

    export default {
        data() {
            return {
                projects: [],
                limit: 10,
                offset: 0,
                count: {data: 0},
                page: 1,
                title: '',
                organization: '',
                filterType: '',
                isMessage: false,
                message: '',
            }
        },
        components: {
            Pagination
        },
        mounted() {
            this.getProjects();
            this.getTotal();
        },
        methods: {
            swapComponent: function(component, dataVar) {
                this.$root.dataVar = dataVar;
                this.$root.currentComponent = component;
            },

            getProjects: function (isFilter = false) {
                if (isFilter) {
                    this.page = 1;
                    this.getTotal();
                }

                this.offset = (this.page - 1) * this.limit;

                axios
                    .get('/admin/api/projects/' + this.limit + '/' + this.offset + this.getLink())
                    .then(response => (this.projects = response));
            },

            getTotal: function () {
                var link = '/admin/api/project/count' + this.getLink();

                axios
                    .get(link)
                    .then(response => (this.count = response));
            },

            getLink() {
                var result = '/' + (this.title ? this.title : '0') + '/'
                    + (this.organization ? this.organization : '0') + '/'
                    + (this.filterType ? this.filterType : '0');

                return result;
            },
            deleteProject(id) {
                axios
                    .get('/admin/api/project/destroy/'+id)
                    .then((response) => {
                        this.getProjects(),
                        this.isMessage = true,
                        this.message = 'Project was deleted'
                    });
            },
            closeMessage() {
                this.isMessage = false;
            },
        },
    }
</script>