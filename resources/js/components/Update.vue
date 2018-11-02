<template>
    <div>
        <div class="row" v-if="messageIsActive">
            <div class="col-xs-12 col-sm-12 col-md-12">
                <div v-bind:class="{'alert-error': hasError, 'alert-success': !hasError}" class="alert alert-dismissible">
                    <button type="button" class="close" @click="closeMessage">×</button>
                    <ul>
                        <li v-for="error in errors">
                            {{ error }}
                        </li>
                    </ul>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-xs-6 col-sm-6 col-md-6">
                <div class="form-group">
                    <label>Title:</label>
                    <input type="text" v-model="project.title" class="form-control">
                </div>
                <div class="form-group">
                    <label>Description:</label>
                    <textarea v-model="project.descrription" class="form-control"></textarea>
                </div>
                <div class="form-group">
                    <label>Organization:</label>
                    <input type="text" v-model="project.organization" class="form-control">
                </div>
                <div class="form-group">
                    <label>Start:</label>
                    <input type="date" v-model="project.start" class="form-control">
                </div>
                <div class="form-group">
                    <label>End:</label>
                    <input type="date" v-model="project.end" class="form-control">
                </div>
            </div>
            <div class="col-xs-6 col-sm-6 col-md-6">
                <div class="form-group">
                    <label>Link:</label>
                    <input type="text" v-model="project.link" class="form-control">
                </div>
                <div class="form-group">
                    <label>Role:</label>
                    <select v-model="project.role" class="form-control">
                        <option value="admin">admin</option>
                        <option value="user">user</option>
                    </select>
                </div>
                <div class="form-group">
                    <label>Type:</label>
                    <select v-model="project.type" class="form-control">
                        <option value="Book">Book</option>
                        <option value="Work">Work</option>
                        <option value="Course">Course</option>
                        <option value="Blog">Blog</option>
                        <option value="Other">Other</option>
                    </select>
                </div>
            </div>
        </div>
        <div class="col-xs-12 col-sm-12 col-md-12 text-right">
            <button class="btn btn-primary" @click="update">Update</button>
        </div>
    </div>
</template>

<script>
    import axios from 'axios';

    export default {
        props: ['id'],
        data: function() {
            return {
                result: {
                    data: {
                        message: ''
                    },
                },
                project: {
                    title: '',
                    descrription: '',
                    organization: '',
                    start: '',
                    end: '',
                    link: '',
                    role: 'admin',
                    type: 'Work',
                },
                messageIsActive: false,
                hasError: false,
                errors: [],
                fieldValidation: [
                    'title', 'link', 'descrription', 'start', 'end', 'role'
                ]
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
            update: function () {
                axios.post('/admin/api/project/update/' + this.id, {
                    title: this.project.title,
                    descrription: this.project.descrription,
                    organization: this.project.organization,
                    start: this.project.start,
                    end: this.project.end,
                    role: this.project.role,
                    link: this.project.link,
                    type: this.project.type,
                }).then((response) => {
                    this.result = response,
                    this.validation()
                }).catch((e) => {
                    console.error(e)
                });
            },
            closeMessage: function() {
                this.messageIsActive = false;
            },
            validation() {
                this.errors = [];

                for (var i = 0; i < this.fieldValidation.length; i++) {
                    var item = this.fieldValidation[i];

                    if (this.result.data.message[item]) {
                        this.errors.push(this.result.data.message[item][0]);
                        this.hasError = false;
                    }
                }

                this.hasError = true;
                if (this.errors.length == 0) {
                    this.hasError = false;
                    this.errors.push('Project was updates');
                }

                this.messageIsActive = true;
            }
        }
    }
</script>