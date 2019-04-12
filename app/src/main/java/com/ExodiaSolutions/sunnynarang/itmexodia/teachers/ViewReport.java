package com.ExodiaSolutions.sunnynarang.itmexodia.teachers;

import android.app.ProgressDialog;
import android.content.Context;
import android.graphics.Color;
import android.os.AsyncTask;
import android.os.Handler;
import android.support.v7.app.ActionBar;
import android.support.v7.app.AppCompatActivity;
import android.os.Bundle;
import android.view.LayoutInflater;
import android.view.MenuItem;
import android.view.View;
import android.view.ViewGroup;
import android.widget.ArrayAdapter;
import android.widget.ImageView;
import android.widget.ListView;
import android.widget.TextView;
import android.widget.Toast;

import com.ExodiaSolutions.sunnynarang.itmexodia.Link;
import com.amulyakhare.textdrawable.TextDrawable;
import com.ExodiaSolutions.sunnynarang.itmexodia.R;

import java.io.BufferedReader;
import java.io.BufferedWriter;
import java.io.IOException;
import java.io.InputStream;
import java.io.InputStreamReader;
import java.io.OutputStream;
import java.io.OutputStreamWriter;
import java.net.HttpURLConnection;
import java.net.MalformedURLException;
import java.net.URL;
import java.net.URLEncoder;
import java.util.ArrayList;

public class ViewReport extends AppCompatActivity {

    String[] color = {"EF5350", "AB47BC", "7E57C2", "5C6BC0", "42A5F5", "29B6F6", "26A69A", "FF7043", "BDBDBD", "78909C"};
    String class_id,subject_id,date,roll_teacher,time,section_id,abs_st_list;
    ArrayList<ViewReportStudent> arrayList = new ArrayList<>();
    CustomAdapter3 adapter;
    ProgressDialog pd;
    @Override
    public boolean onOptionsItemSelected(MenuItem item) {
        switch (item.getItemId()) {
            case android.R.id.home:
                //Write your logic here
                ViewReport.this.finish();
                this.finish();
                return true;
            default:
                return super.onOptionsItemSelected(item);
        }
    }
    @Override
    protected void onCreate(Bundle savedInstanceState) {
        super.onCreate(savedInstanceState);
        setContentView(R.layout.activity_view_report);
        ActionBar actionBar = getSupportActionBar();
        actionBar.setTitle("Class Report");
        actionBar.setHomeButtonEnabled(true);
        actionBar.setDisplayHomeAsUpEnabled(true);

        class_id = getIntent().getStringExtra("class_id");
        time = getIntent().getStringExtra("time");
        subject_id = getIntent().getStringExtra("subject_id");
        date = getIntent().getStringExtra("date");
        roll_teacher = getIntent().getStringExtra("roll");
        section_id = getIntent().getStringExtra("section_id");
        abs_st_list =getIntent().getStringExtra("absent_st_list");
        ListView listView = (ListView) findViewById(R.id.view_reports_listview);
        adapter = new CustomAdapter3(ViewReport.this,arrayList);
        listView.setAdapter(adapter);
        final ReportLoader reportLoader  = new ReportLoader(ViewReport.this);
        reportLoader.execute();

        Handler handler = new Handler();
        handler.postDelayed(new Runnable()
        {
            @Override
            public void run() {
                if ( reportLoader.getStatus() == AsyncTask.Status.RUNNING )
                {reportLoader.cancel(true);
                    Toast.makeText(ViewReport.this, "Time OUT", Toast.LENGTH_SHORT).show();
                    if(pd.isIndeterminate())
                    pd.dismiss();
                }
            }
        }, 20000 );
    }
    class CustomAdapter3 extends ArrayAdapter<ViewReportStudent> {
        Context c;

        public CustomAdapter3(Context context, ArrayList<ViewReportStudent> arrayList) {
            super(context, R.layout.view_report_lv_card, arrayList);
            this.c = context;
        }

        @Override
        public View getView(int pos, View convertView, ViewGroup parent) {

            LayoutInflater li = (LayoutInflater) c.getSystemService(c.LAYOUT_INFLATER_SERVICE);
            convertView = li.inflate(R.layout.view_report_lv_card, parent, false);

            ViewReportStudent s = getItem(pos);
            TextView roll = (TextView) convertView.findViewById(R.id.view_reports_roll);
            TextView name = (TextView) convertView.findViewById(R.id.view_reports_name);
            TextView status = (TextView) convertView.findViewById(R.id.view_reports_status);
            ImageView imageView = (ImageView) convertView.findViewById(R.id.view_reports_imge);
            int col=pos;
            if(pos>=10){
                col=pos%10;
            }
            TextDrawable drawable = TextDrawable.builder()
                    .buildRound(String.valueOf(s.getName().charAt(0)), Color.parseColor("#"+color[col]));
            imageView.setImageDrawable(drawable);
            name.setText(s.getName());
            roll.setText(s.getRoll());
            if(s.getStatus().equalsIgnoreCase("0"))
            {status.setText("A");
            status.setTextColor(Color.parseColor("#ff6138"));}
            else{
            status.setText("P");}
            
            return convertView;

        }
    }

    public class ReportLoader extends AsyncTask<Void,Void,String> {

        Context context;

        ReportLoader(Context context)
        {
            this.context=context;
        }


        @Override
        protected String doInBackground(Void... params) {

            String login_url= null;
            if( Link.getInstance().getHashMapLink().containsKey("view_att_report_click")){
                login_url = Link.getInstance().getHashMapLink().get("view_att_report_click");
            }

            try{

                URL url =new URL(login_url);
                HttpURLConnection httpurlconnection= (HttpURLConnection) url.openConnection();
                httpurlconnection.setRequestMethod("POST");
                httpurlconnection.setDoOutput(true);
                httpurlconnection.setDoInput(true);

                OutputStream outputstream = httpurlconnection.getOutputStream();
                BufferedWriter bufferedwriter = new BufferedWriter(new OutputStreamWriter(outputstream, "UTF-8"));

                String post_data = URLEncoder.encode("section", "UTF-8") + "=" + URLEncoder.encode(section_id, "UTF-8");

                bufferedwriter.write(post_data);
                bufferedwriter.flush();
                bufferedwriter.close();

                InputStream inputstream= httpurlconnection.getInputStream();
                BufferedReader bufferedreader= new BufferedReader(new InputStreamReader(inputstream,"iso-8859-1"));
                String result="";
                String line="";
                while((line = bufferedreader.readLine())!=null){
                    result+=line;
                }
                bufferedreader.close();
                inputstream.close();
                httpurlconnection.disconnect();

                return result;

            }catch(MalformedURLException e){
                e.printStackTrace();
            } catch (IOException e) {
                e.printStackTrace();
            }

            return "";
        }


        @Override
        protected void onPreExecute() {
            super.onPreExecute();
            //Toast.makeText(context, ""+time, Toast.LENGTH_SHORT).show();
                pd = new ProgressDialog(ViewReport.this);
                pd.setTitle("Loading.");
                pd.setMessage("Please wait...\nLoading Report.");
                pd.setCancelable(false);
                pd.show();
        }

        @Override
        protected void onPostExecute(String result ){
            pd.dismiss();
            if(!result.equalsIgnoreCase("")){
                String absent[] = abs_st_list.split(",");
                arrayList.addAll(ViewReportStudent.jsonToArraylist(result,absent));
                adapter.notifyDataSetChanged();
            }


        }
}}
