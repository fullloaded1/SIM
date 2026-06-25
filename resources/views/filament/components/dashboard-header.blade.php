<div style="display: flex; gap: 20px; width: 100%; margin-bottom: 20px; flex-wrap: wrap; align-items: stretch;">
    
    <div x-data="{ 
            activeSlide: 1, 
            slideCount: 2,
            next() { this.activeSlide = this.activeSlide === this.slideCount ? 1 : this.activeSlide + 1 },
            prev() { this.activeSlide = this.activeSlide === 1 ? this.slideCount : this.activeSlide - 1 }
         }" 
         x-init="setInterval(() => next(), 5000)"
         style="flex: 2; min-width: 300px; position: relative; overflow: hidden; border-radius: 12px; box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1); min-height: 180px;">
        
        <div style="width: 100%; height: 100%; min-height: 180px; display: flex; position: relative;">
            <div x-show="activeSlide === 1" x-transition.opacity.duration.500ms
                 style="background: linear-gradient(135deg, #534AB7 0%, #26215C 100%); position: absolute; inset: 0; color: white; display: flex; align-items: flex-end; padding: 25px; box-sizing: border-box;">
                <div style="position: absolute; inset: 0; background: linear-gradient(to top, rgba(0,0,0,0.7) 0%, rgba(0,0,0,0.1) 100%); z-index: 1;"></div>
                <div style="position: relative; z-index: 2;">
                    <h3 style="font-size: 22px; font-weight: 800; margin: 0; color: #ffffff !important;">Sistem Informasi</h3>
                    <p style="margin: 4px 0 0 0; font-size: 13px; opacity: 0.9;">Human Centered-Design & Enterprise</p>
                </div>
            </div>
            <div x-show="activeSlide === 2" x-transition.opacity.duration.500ms
                 style="background: linear-gradient(135deg, #1D9E75 0%, #085041 100%); position: absolute; inset: 0; color: white; display: flex; align-items: flex-end; padding: 25px; box-sizing: border-box;">
                <div style="position: absolute; inset: 0; background: linear-gradient(to top, rgba(0,0,0,0.7) 0%, rgba(0,0,0,0.1) 100%); z-index: 1;"></div>
                <div style="position: relative; z-index: 2;">
                    <h3 style="font-size: 22px; font-weight: 800; margin: 0; color: #ffffff !important;">Layanan Literasi Digital</h3>
                    <p style="margin: 4px 0 0 0; font-size: 13px; opacity: 0.9;">Otomatisasi sirkulasi data real-time.</p>
                </div>
            </div>
        </div>
        <button @click="prev()" style="position: absolute; left: 10px; top: 50%; transform: translateY(-50%); z-index: 10; background: rgba(0,0,0,0.2); border: none; color: white; width: 28px; height: 28px; border-radius: 50%; cursor: pointer;">&#10094;</button>
        <button @click="next()" style="position: absolute; right: 10px; top: 50%; transform: translateY(-50%); z-index: 10; background: rgba(0,0,0,0.2); border: none; color: white; width: 28px; height: 28px; border-radius: 50%; cursor: pointer;">&#10095;</button>
    </div>

    <div style="flex: 1; min-width: 250px; background: linear-gradient(135deg, #1D9E75 0%, #085041 100%); color: white; border-radius: 12px; padding: 25px; box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1); display: flex; flex-direction: column; justify-content: center; box-sizing: border-box; position: relative; overflow: hidden;">
        <div style="position: absolute; right: -10px; top: -10px; font-size: 80px; opacity: 0.1; user-select: none;">💻</div>
        <div style="position: relative; z-index: 2;">
          <span style="font-size: 10px; background: rgba(255,255,255,0.2); padding: 3px 8px; border-radius: 20px; font-weight: 600; text-transform: uppercase; color: #ffffff !important;">
              ADMIN PANEL 👤
          </span>
          <h3 style="font-size: 26px; font-weight: 800; margin: 8px 0 2px 0; color: #ffffff !important; line-height: 1.2;">
              {{ now()->translatedFormat('l,') }}
          </h3>
          <h4 style="font-size: 15px; font-weight: 700; margin: 0; color: #ffffff !important; opacity: 0.95; margin-bottom: 2px;">
              {{ now()->translatedFormat('d F Y') }}
          </h4>
          <span style="font-size: 11px; opacity: 0.8;">Server: {{ now()->format('H:i') }} WIB</span>
        </div>
    </div>

</div>