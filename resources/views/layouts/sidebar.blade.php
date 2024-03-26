@if(isset($project))
    <aside class="py-12 pl-8 pr-4 sm:pl-6 lg:pl-8 col-md-3 bg-light border me-3">
        <div class="h-screen px-3 py-4 overflow-y-auto bg-gray-50 dark:bg-gray-800">
            <ul class="nav flex-column">
                <li class="nav-item">
                    <a href="#"
                       class="nav-link py-3 text-dark rounded-lg hover:bg-gray-100 dark:hover:bg-gray-700 group d-flex">
                        <svg
                            width="22"
                            height="22"
                            class="w-5 h-5 text-gray-500 transition duration-75 dark:text-gray-400 group-hover:text-gray-900 dark:group-hover:text-white"
                            aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor"
                            viewBox="0 0 22 21">
                            <path
                                d="M16.975 11H10V4.025a1 1 0 0 0-1.066-.998 8.5 8.5 0 1 0 9.039 9.039.999.999 0 0 0-1-1.066h.002Z"/>
                            <path
                                d="M12.5 0c-.157 0-.311.01-.565.027A1 1 0 0 0 11 1.02V10h8.975a1 1 0 0 0 1-.935c.013-.188.028-.374.028-.565A8.51 8.51 0 0 0 12.5 0Z"/>
                            <span class="ms-3">Dashboard</span>
                        </svg>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{route('issues.index', ['projectId' => $project->id])}}"
                       class="nav-link py-3 text-dark rounded-lg hover:bg-gray-100 dark:hover:bg-gray-700 group d-flex">
                        <svg width="22" height="22" viewBox="0 0 24 24" role="presentation">
                            <g fill="currentColor" fill-rule="evenodd">
                                <path
                                    d="M5 12.991c0 .007 14.005.009 14.005.009C18.999 13 19 5.009 19 5.009 19 5.002 4.995 5 4.995 5 5.001 5 5 12.991 5 12.991zM3 5.01C3 3.899 3.893 3 4.995 3h14.01C20.107 3 21 3.902 21 5.009v7.982c0 1.11-.893 2.009-1.995 2.009H4.995A2.004 2.004 0 013 12.991V5.01zM19 19c-.005 1.105-.9 2-2.006 2H7.006A2.009 2.009 0 015 19h14zm1-3a2.002 2.002 0 01-1.994 2H5.994A2.003 2.003 0 014 16h16z"
                                    fill-rule="nonzero"></path>
                                <path
                                    d="M10.674 11.331c.36.36.941.36 1.3 0l2.758-2.763a.92.92 0 00-1.301-1.298l-2.108 2.11-.755-.754a.92.92 0 00-1.3 1.3l1.406 1.405z"></path>
                            </g>
                        </svg>
                        <span class="ms-3">Issues</span>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{route('workFlows.index', ['projectId' => $project->id])}}"
                       class="nav-link py-3 text-dark rounded-lg hover:bg-gray-100 dark:hover:bg-gray-700 group d-flex">
                        <svg width="22" height="22" viewBox="0 0 24 24" role="presentation">
                            <g fill="currentColor">
                                <path
                                    d="M5 19.002C5 19 17 19 17 19v-2.002C17 17 5 17 5 17v2.002zm-2-2.004C3 15.894 3.895 15 4.994 15h12.012c1.101 0 1.994.898 1.994 1.998v2.004A1.997 1.997 0 0117.006 21H4.994A1.998 1.998 0 013 19.002v-2.004z"></path>
                                <path d="M5 15h12v-2H5v2zm-2-4h16v6H3v-6z"></path>
                                <path
                                    d="M7 11.002C7 11 19 11 19 11V8.998C19 9 7 9 7 9v2.002zM5 8.998C5 7.894 5.895 7 6.994 7h12.012C20.107 7 21 7.898 21 8.998v2.004A1.997 1.997 0 0119.006 13H6.994A1.998 1.998 0 015 11.002V8.998z"></path>
                                <path
                                    d="M5 5v2h12V5H5zm-2-.002C3 3.894 3.895 3 4.994 3h12.012C18.107 3 19 3.898 19 4.998V9H3V4.998z"></path>
                            </g>
                        </svg>
                        <span class="ms-3">{{__('Workflows')}}</span>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{route('roles.index', ['projectId' => $project->id])}}"
                       class="nav-link py-3 text-dark rounded-lg hover:bg-gray-100 dark:hover:bg-gray-700 group d-flex">
                        <svg width="22" height="22" viewBox="0 0 576 512">
                            <path
                                d="M288 32c-80.8 0-145.5 36.8-192.6 80.6C48.6 156 17.3 208 2.5 243.7c-3.3
                                7.9-3.3 16.7 0 24.6C17.3 304 48.6 356 95.4 399.4C142.5 443.2 207.2 480 288
                                480s145.5-36.8 192.6-80.6c46.8-43.5 78.1-95.4 93-131.1c3.3-7.9 3.3-16.7
                                0-24.6c-14.9-35.7-46.2-87.7-93-131.1C433.5 68.8 368.8 32 288 32zM144 256a144
                                144 0 1 1 288 0 144 144 0 1 1 -288 0zm144-64c0 35.3-28.7 64-64 64c-7.1
                                0-13.9-1.2-20.3-3.3c-5.5-1.8-11.9 1.6-11.7 7.4c.3 6.9 1.3 13.8 3.2 20.7c13.7
                                51.2 66.4 81.6 117.6 67.9s81.6-66.4 67.9-117.6c-11.1-41.5-47.8-69.4-88.6-71.1c-5.8-.2-9.2
                                6.1-7.4 11.7c2.1 6.4 3.3 13.2 3.3 20.3z"/>
                        </svg>
                        <span class="ms-3">Roles</span>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{route('issueTypes.index', ['projectId' => $project->id])}}"
                       class="nav-link py-3 text-dark rounded-lg hover:bg-gray-100 dark:hover:bg-gray-700 group d-flex">
                        <svg width="22" height="22" viewBox="0 0 576 512">
                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512">
                                <path
                                    d="M315.4 15.5C309.7 5.9 299.2 0 288 0s-21.7 5.9-27.4 15.5l-96 160c-5.9 9.9-6.1
                                        22.2-.4 32.2s16.3 16.2 27.8 16.2H384c11.5 0 22.2-6.2 27.8-16.2s5.5-22.3-.4-32.2l-96-160zM288 312V456c0
                                        22.1 17.9 40 40 40H472c22.1 0 40-17.9 40-40V312c0-22.1-17.9-40-40-40H328c-22.1 0-40 17.9-40
                                        40zM128 512a128 128 0 1 0 0-256 128 128 0 1 0 0 256z"/>
                            </svg>
                        </svg>
                        <span class="ms-3">Issue types</span>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{route('logTimes.index', ['projectId' => $project->id])}}"
                       class="nav-link py-3 text-dark rounded-lg hover:bg-gray-100 dark:hover:bg-gray-700 group d-flex">
                        <svg
                            width="20"
                            height="20"
                            xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512">
                            <path
                                d="M464 256A208 208 0 1 1 48 256a208 208 0 1 1 416 0zM0 256a256
                                256 0 1 0 512 0A256 256 0 1 0 0 256zM232 120V256c0 8 4 15.5 10.7
                                20l96 64c11 7.4 25.9 4.4 33.3-6.7s4.4-25.9-6.7-33.3L280 243.2V120c0-13.3-10.7-24-24-24s-24
                                10.7-24 24z"/>
                        </svg>
                        <span class="ms-3">Spent time</span>
                    </a>
                </li>
            </ul>
        </div>
    </aside>
@endif
