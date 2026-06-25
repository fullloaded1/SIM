<div style="background: linear-gradient(135deg, #16a34a 0%, #15803d 100%); color: white; border-radius: 12px; padding: 35px 30px; box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1); display: flex; flex-direction: column; justify-content: center; min-height: 240px; box-sizing: border-box; position: relative; overflow: hidden; height: 100%;">
    
    <div style="position: absolute; right: -15px; top: -15px; font-size: 110px; opacity: 0.12; user-select: none;">💻</div>
    
    <div style="position: relative; z-index: 2;">
        <span style="font-size: 11px; background: rgba(255,255,255,0.2); padding: 4px 10px; border-radius: 20px; font-weight: 600; text-transform: uppercase; color: #ffffff !important;">
            Admin: {{ auth()->user()->name }} 👋
        </span>
        <h3 style="font-size: 26px; font-weight: 800; margin: 15px 0 5px 0; color: #ffffff !important; line-height: 1.2;">
            {{ now()->translatedFormat('l,') }}
        </h3>
        <h4 style="font-size: 18px; font-weight: 700; margin: 0; color: #ffffff !important; opacity: 0.95;">
            {{ now()->translatedFormat('d F Y') }}
        </h4>
        <p style="font-size: 13px; margin-top: 10px; opacity: 0.8; font-weight: 500;">
            Server: <span style="font-weight: 700;">{{ now()->format('H:i') }} WIB</span>
        </p>
    </div>
</div>