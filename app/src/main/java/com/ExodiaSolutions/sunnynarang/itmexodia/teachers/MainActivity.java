package com.ExodiaSolutions.sunnynarang.itmexodia.teachers;

import android.content.Intent;
import android.graphics.Color;
import android.os.Build;
import android.os.Handler;
import android.support.v7.app.ActionBar;
import android.support.v7.app.AppCompatActivity;
import android.os.Bundle;
import android.view.Window;
import android.view.WindowManager;
import android.widget.ImageView;

//import com.bumptech.glide.Glide;
import com.ExodiaSolutions.sunnynarang.itmexodia.R;
import com.ExodiaSolutions.sunnynarang.itmexodia.login;

public class MainActivity extends AppCompatActivity {

    @Override
    public void onBackPressed() {

    }

    @Override
    protected void onCreate(Bundle savedInstanceState) {
        super.onCreate(savedInstanceState);
        Window window= MainActivity.this.getWindow();
        setContentView(R.layout.activity_main);
        ImageView ivGif = (ImageView) findViewById(R.id.gif);
        // Display the GIF (from raw resource) into the ImageView
        //Glide.with(this).load(R.raw.loader).asGif().into(ivGif);
        window.addFlags(WindowManager.LayoutParams.FLAG_DRAWS_SYSTEM_BAR_BACKGROUNDS);
        window.clearFlags(WindowManager.LayoutParams.FLAG_TRANSLUCENT_STATUS);
        if (Build.VERSION.SDK_INT >= Build.VERSION_CODES.LOLLIPOP) {
            window.setStatusBarColor(Color.parseColor("#ff8800"));
        }
        ActionBar actionBar = getSupportActionBar(); // or getActionBar();
        actionBar.hide();
        final Handler handler = new Handler();
        handler.postDelayed(new Runnable() {
            @Override
            public void run() {
                // Do something after 5s = 5000ms
                Intent i  = new Intent(MainActivity.this,login.class);
                startActivity(i);
                MainActivity.this.finish();

            }
        }, 3000);

    }
}
