<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ $campaign->subject }} | Ameda Global Campaign Studio</title>

    <!-- Tailwind CSS -->
    <script src="https://cdn.tailwindcss.com"></script>

    <!-- GrapesJS Core & Preset Styles -->
    <link href="https://unpkg.com/grapesjs/dist/css/grapes.min.css" rel="stylesheet">
    <script src="https://unpkg.com/grapesjs"></script>

    <!-- Lucide Icons -->
    <script src="https://unpkg.com/lucide@latest"></script>

    <style>
        /* Modern 2026 Reset & Canvas Polish */
        .gjs-cv-canvas {
            top: 0 !important;
            width: 100% !important;
            height: 100% !important;
            background-color: #f1f5f9 !important;
        }

        .gjs-block {
            border: 1px solid #e2e8f0;
            border-radius: 12px;
            padding: 14px 16px;
            background: white;
            margin-bottom: 12px;
            cursor: grab;
            transition: all 0.2s cubic-bezier(0.16, 1, 0.3, 1);
            box-shadow: 0 1px 2px rgba(0, 0, 0, 0.02);
            display: flex;
            align-items: center;
            gap: 12px;
            font-weight: 600;
            font-size: 0.85rem;
            color: #1e293b;
        }

        .gjs-block:hover {
            border-color: #3b82f6;
            color: #2563eb;
            box-shadow: 0 10px 25px -5px rgba(59, 130, 246, 0.15);
            transform: translateY(-2px);
        }

        /* Sleek Modal / Asset Manager Customization */
        .gjs-am-modal {
            border-radius: 1.5rem !important;
            box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.25) !important;
            border: 1px solid #e2e8f0 !important;
        }

        .gjs-am-file-uploader {
            border: 2px dashed #cbd5e1;
            padding: 40px;
            border-radius: 1rem;
            background: #f8fafc;
            text-align: center;
            cursor: pointer;
            transition: all 0.2s;
        }

        .gjs-am-file-uploader:hover {
            border-color: #2563eb;
            background: #f0fdf4;
        }

        /* Custom Scrollbars */
        ::-webkit-scrollbar {
            width: 6px;
            height: 6px;
        }

        ::-webkit-scrollbar-track {
            background: transparent;
        }

        ::-webkit-scrollbar-thumb {
            background: #cbd5e1;
            border-radius: 9999px;
        }

        ::-webkit-scrollbar-thumb:hover {
            background: #94a3b8;
        }
    </style>
</head>

<body class="bg-slate-50 font-sans h-screen flex flex-col overflow-hidden select-none m-0">

    <!-- TOP ENTERPRISE NAVIGATION BAR -->
    <header
        class="bg-white border-b border-slate-200 px-6 py-3.5 flex justify-between items-center shrink-0 z-30 shadow-sm">
        <div class="flex items-center gap-5">
            <a href="/admin/insights"
                class="p-2.5 text-slate-400 hover:text-slate-700 hover:bg-slate-100 rounded-xl transition-all"
                title="Back to Dashboard">
                <i data-lucide="arrow-left" class="w-5 h-5"></i>
            </a>
            <div class="flex items-center gap-3">
                <input type="text" id="campaign-subject" value="{{ $campaign->subject }}"
                    class="font-extrabold text-base text-slate-900 border border-slate-200 hover:border-slate-300 focus:border-blue-600 focus:ring-4 focus:ring-blue-600/10 rounded-xl px-4 py-2 outline-none w-96 transition-all bg-slate-50/50">
                <span
                    class="text-xs font-bold text-emerald-700 bg-emerald-50 border border-emerald-200/60 px-3 py-1.5 rounded-xl flex items-center gap-2">
                    <span class="w-2 h-2 rounded-full bg-emerald-500 animate-pulse"></span> Auto-Saved
                </span>
            </div>
        </div>

        <div class="flex items-center gap-3">
            <button
                class="bg-blue-50/80 hover:bg-blue-100 text-blue-700 px-4 py-2.5 rounded-xl text-xs font-black uppercase tracking-wider flex items-center gap-2 transition-all border border-blue-100">
                <i data-lucide="sparkles" class="w-4 h-4 text-blue-600"></i> AI Assistant
            </button>
            <button
                class="text-xs font-bold text-slate-600 hover:text-slate-900 px-4 py-2.5 rounded-xl hover:bg-slate-100 transition-all">Preview
                & Test</button>
            <button onclick="saveCampaign()" id="save-btn"
                class="bg-blue-600 hover:bg-blue-700 text-white px-6 py-2.5 rounded-xl text-xs font-black uppercase tracking-wider shadow-lg shadow-blue-600/20 transition-all flex items-center gap-2">
                <i data-lucide="save" class="w-4 h-4"></i> Save & Continue
            </button>
        </div>
    </header>

    <!-- MAIN APP CONTAINER -->
    <div class="flex-1 flex overflow-hidden relative w-full h-[calc(100vh-4.5rem)]">

        <!-- LEFT SIDEBAR: CONTENT BLOCKS -->
        <div
            class="w-80 bg-white border-r border-slate-200 flex flex-col shrink-0 z-20 shadow-[4px_0_24px_rgba(0,0,0,0.02)]">
            <div class="p-5 border-b border-slate-100 flex items-center justify-between">
                <span class="text-xs font-extrabold uppercase tracking-widest text-slate-400">Campaign Elements</span>
                <span class="text-[0.65rem] font-bold bg-slate-100 text-slate-600 px-2 py-0.5 rounded-md">Drag &
                    Drop</span>
            </div>

            <div class="p-6 overflow-y-auto flex-1 space-y-4">
                <div id="blocks-container" class="flex flex-col gap-2"></div>
            </div>
        </div>

        <!-- CENTER GENTLE CANVAS AREA -->
        <div class="flex-1 bg-slate-100/80 relative h-full flex flex-col">
            <div id="gjs" class="w-full h-full"></div>
        </div>

        <!-- RIGHT SIDEBAR: PROPERTIES & STYLES INSPECTOR -->
        <div
            class="w-80 bg-white border-l border-slate-200 flex flex-col shrink-0 z-20 shadow-[-4px_0_24px_rgba(0,0,0,0.02)] overflow-y-auto">
            <div class="p-5 border-b border-slate-100">
                <span class="text-xs font-extrabold uppercase tracking-widest text-slate-400">Inspector & Styles</span>
            </div>
            <div id="styles-container" class="p-5 flex-1 space-y-6">
                <!-- GrapesJS Style Manager & Traits will inject dynamically here -->
            </div>
        </div>

    </div>


    <!-- SCRIPT INITIALIZATION WITH ADVANCED LAYOUT BLOCKS -->
    <script>
        document.addEventListener('DOMContentLoaded', () => {
            lucide.createIcons();

            const editor = grapesjs.init({
                container: '#gjs',
                height: '100%',
                width: 'auto',
                storageManager: false,
                blockManager: {
                    appendTo: '#blocks-container',
                },
                styleManager: {
                    appendTo: '#styles-container',
                },
                assetManager: {
                    upload: "{{ route('campaigns.upload-image') }}",
                    uploadName: 'file',
                    headers: {
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                    },
                    embedAsBase64: false,
                },
                deviceManager: {
                    devices: [
                        { name: 'Desktop', width: '' },
                        { name: 'Mobile', width: '375px' }
                    ]
                }
            });

            const bm = editor.BlockManager;

            // ==========================================
            // CATEGORY 1: BASIC CONTENT ELEMENTS
            // ==========================================
            bm.add('text-block', {
                label: '<div style="display:flex;align-items:center;gap:10px;"><span style="font-size:16px;">📝</span> <div><div style="font-weight:700;">Text Paragraph</div><div style="font-size:11px;color:#64748b;">Editable text block</div></div></div>',
                content: '<p style="font-size: 15px; line-height: 1.6; color: #334155; padding: 10px 0;">Write your professional message here. Highlight key updates or corporate announcements for your subscribers.</p>',
                category: 'Basic Elements'
            });

            bm.add('image-block', {
                label: '<div style="display:flex;align-items:center;gap:10px;"><span style="font-size:16px;">🖼️</span> <div><div style="font-weight:700;">Image Upload</div><div style="font-size:11px;color:#64748b;">Banners & graphics</div></div></div>',
                content: '<div style="padding: 30px; text-align: center; background: #f8fafc; border: 2px dashed #cbd5e1; border-radius: 12px; color: #64748b; font-weight: 600; margin: 10px 0;">Double-click or select to upload image</div>',
                category: 'Basic Elements'
            });

            bm.add('button-block', {
                label: '<div style="display:flex;align-items:center;gap:10px;"><span style="font-size:16px;">🔗</span> <div><div style="font-weight:700;">Action Button</div><div style="font-size:11px;color:#64748b;">Call to action link</div></div></div>',
                content: '<div style="text-align: center; padding: 15px 0;"><a href="#" style="background: #2563eb; color: #ffffff; padding: 14px 32px; border-radius: 10px; text-decoration: none; font-weight: bold; display: inline-block; font-size: 15px; box-shadow: 0 4px 12px rgba(37, 99, 235, 0.2);">Explore More</a></div>',
                category: 'Basic Elements'
            });

            bm.add('divider-block', {
                label: '<div style="display:flex;align-items:center;gap:10px;"><span style="font-size:16px;">➖</span> <div><div style="font-weight:700;">Divider Line</div><div style="font-size:11px;color:#64748b;">Section separator</div></div></div>',
                content: '<hr style="border: none; border-top: 1px solid #e2e8f0; margin: 25px 0;">',
                category: 'Basic Elements'
            });

            // ==========================================
            // CATEGORY 2: PRE-DEFINED LAYOUT SECTIONS
            // ==========================================
            bm.add('layout-hero', {
                label: '<div style="display:flex;align-items:center;gap:10px;"><span style="font-size:16px;">⭐</span> <div><div style="font-weight:700;">Hero Banner</div><div style="font-size:11px;color:#64748b;">Header with title & CTA</div></div></div>',
                content: `
                    <div style="background: #1e293b; color: #ffffff; padding: 40px 30px; border-radius: 12px; text-align: center; margin: 15px 0;">
                        <h2 style="font-size: 26px; font-weight: 900; margin-bottom: 12px; color: #ffffff;">Special Announcement</h2>
                        <p style="font-size: 14px; color: #94a3b8; line-height: 1.5; margin-bottom: 20px;">Discover our latest global enterprise updates and high-performance offerings.</p>
                        <a href="#" style="background: #3b82f6; color: #ffffff; padding: 10px 24px; border-radius: 8px; text-decoration: none; font-weight: bold; font-size: 13px; display: inline-block;">Get Started</a>
                    </div>
                `,
                category: 'Pre-defined Layouts'
            });

            bm.add('layout-two-column', {
                label: '<div style="display:flex;align-items:center;gap:10px;"><span style="font-size:16px;">📊</span> <div><div style="font-weight:700;">2-Column Split</div><div style="font-size:11px;color:#64748b;">Image left, text right</div></div></div>',
                content: `
                    <table width="100%" cellpadding="0" cellspacing="0" style="margin: 20px 0;">
                        <tr>
                            <td width="48%" style="background: #f8fafc; border: 2px dashed #cbd5e1; padding: 25px; text-align: center; border-radius: 8px; color: #64748b; font-size: 13px;">
                                [ Image / Graphic ]
                            </td>
                            <td width="4%"></td>
                            <td width="48%" style="vertical-align: top;">
                                <h3 style="font-size: 18px; font-weight: 800; color: #0f172a; margin-bottom: 10px;">Feature Highlight</h3>
                                <p style="font-size: 14px; color: #475569; line-height: 1.6;">Explain your product features or service metrics clearly in this structured split column view.</p>
                            </td>
                        </tr>
                    </table>
                `,
                category: 'Pre-defined Layouts'
            });

            bm.add('layout-cta-card', {
                label: '<div style="display:flex;align-items:center;gap:10px;"><span style="font-size:16px;">🎯</span> <div><div style="font-weight:700;">CTA Highlight Box</div><div style="font-size:11px;color:#64748b;">Notice card with border</div></div></div>',
                content: `
                    <div style="background: #f0fdf4; border: 1px solid #bbf7d0; border-left: 4px solid #22c55e; padding: 20px 24px; border-radius: 8px; margin: 20px 0;">
                        <h4 style="font-size: 16px; font-weight: 800; color: #166534; margin-bottom: 6px;">Important Notice</h4>
                        <p style="font-size: 14px; color: #15803d; line-height: 1.5; margin: 0;">Your subscription status is active. Review your procurement dashboards for real-time order tracking.</p>
                    </div>
                `,
                category: 'Pre-defined Layouts'
            });

            bm.add('layout-footer', {
                label: '<div style="display:flex;align-items:center;gap:10px;"><span style="font-size:16px;">🏢</span> <div><div style="font-weight:700;">Corporate Footer</div><div style="font-size:11px;color:#64748b;">Copyright & unsubscribe</div></div></div>',
                content: `
                    <div style="text-align: center; padding: 30px 0; border-top: 1px solid #e2e8f0; margin-top: 30px; color: #94a3b8; font-size: 12px; line-height: 1.6;">
                        <p style="margin-bottom: 8px; font-weight: 600; color: #64748b;">Ameda Global Pvt. Ltd. • Mumbai, India</p>
                        <p style="margin-bottom: 8px;">You are receiving this email because you opted in via our corporate portal.</p>
                        <p><a href="#" style="color: #3b82f6; text-decoration: underline;">Unsubscribe</a> | <a href="#" style="color: #3b82f6; text-decoration: underline;">View in browser</a></p>
                    </div>
                `,
                category: 'Pre-defined Layouts'
            });

            // Load saved JSON or default template
            const savedJson = {!! json_encode($campaign->json_content) !!};
            if (savedJson && savedJson.trim() !== '') {
                try {
                    editor.loadProjectData(JSON.parse(savedJson));
                } catch (e) {
                    console.error('Failed to parse saved JSON', e);
                }
            } else {
                editor.setComponents(`
                    <div style="max-width: 650px; margin: 50px auto; background: white; padding: 50px; border-radius: 20px; font-family: system-ui, sans-serif; color: #1e293b; box-shadow: 0 20px 25px -5px rgba(0,0,0,0.05);">
                        <h1 style="text-align: center; font-weight: 900; font-size: 32px; color: #0f172a; margin-bottom: 30px; letter-spacing: -0.025em;">Ameda Global Update</h1>
                        <div style="padding: 40px 20px; text-align: center; background: #f8fafc; border: 2px dashed #cbd5e1; border-radius: 12px; color: #64748b; font-weight: 600; margin-bottom: 25px;">
                            [ Double-click here to upload your campaign banner ]
                        </div>
                        <p style="font-size: 15px; line-height: 1.7; color: #334155; margin-bottom: 20px;">
                            Welcome to the campaign studio. Drag layout blocks from the left sidebar to build professional newsletters instantly.
                        </p>
                    </div>
                `);
            }

            // Global Save Handler
            window.saveCampaign = function () {
                const btn = document.getElementById('save-btn');
                btn.innerHTML = `<i data-lucide="loader-2" class="w-4 h-4 animate-spin"></i> Saving...`;
                lucide.createIcons();

                const htmlContent = editor.getHtml() + `<style>${editor.getCss()}</style>`;
                const jsonContent = JSON.stringify(editor.getProjectData());
                const subject = document.getElementById('campaign-subject').value;

                fetch("{{ route('admin.campaigns.update', $campaign->id) }}", {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                    },
                    body: JSON.stringify({ subject, html_content: htmlContent, json_content: jsonContent })
                })
                    .then(res => res.json())
                    .then(data => {
                        alert(data.message);
                        btn.innerHTML = `<i data-lucide="save" class="w-4 h-4"></i> Save & Continue`;
                        lucide.createIcons();
                    })
                    .catch(() => {
                        alert('Failed to save campaign.');
                        btn.innerHTML = `<i data-lucide="save" class="w-4 h-4"></i> Save & Continue`;
                        lucide.createIcons();
                    });
            };
        });
    </script>
</body>

</html>