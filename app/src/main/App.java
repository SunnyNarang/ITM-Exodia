package com.ExodiaSolutions.sunnynarang.itmexodia;

import android.app.Application;

import uk.co.chrisjenx.calligraphy.CalligraphyConfig;

/**
 * Created by shriram on 7/21/2016.
 */
public class App extends Application {
    @Override
    public void onCreate() {
        super.onCreate();

        CalligraphyConfig.initDefault(new CalligraphyConfig.Builder()
                .setDefaultFontPath("fonts/Lato-semibold.ttf")
                .setFontAttrId(R.attr.fontPath)
                .build()
        );
    }
}