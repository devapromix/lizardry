object FormInfo: TFormInfo
  Left = 0
  Top = 0
  BorderIcons = [biSystemMenu]
  BorderStyle = bsSingle
  Caption = 'Lizardry'
  ClientHeight = 458
  ClientWidth = 749
  Color = clBtnFace
  Font.Charset = DEFAULT_CHARSET
  Font.Color = clWindowText
  Font.Height = -11
  Font.Name = 'Tahoma'
  Font.Style = []
  OldCreateOrder = False
  PixelsPerInch = 96
  TextHeight = 13
  object PageControl1: TPageControl
    Left = 0
    Top = 0
    Width = 749
    Height = 458
    ActivePage = TabSheet3
    Align = alClient
    TabOrder = 0
    object TabSheet1: TTabSheet
      Caption = #1051#1086#1082#1072#1094#1080#1103
      object RichEdit1: TRichEdit
        Left = 0
        Top = 0
        Width = 741
        Height = 430
        Align = alClient
        Font.Charset = RUSSIAN_CHARSET
        Font.Color = clWindowText
        Font.Height = -11
        Font.Name = 'Tahoma'
        Font.Style = []
        ParentFont = False
        ScrollBars = ssVertical
        TabOrder = 0
        Zoom = 100
      end
    end
    object TabSheet2: TTabSheet
      Caption = #1055#1088#1077#1076#1084#1077#1090#1099
      ImageIndex = 1
      object RichEdit2: TRichEdit
        Left = 0
        Top = 0
        Width = 741
        Height = 430
        Align = alClient
        Font.Charset = RUSSIAN_CHARSET
        Font.Color = clWindowText
        Font.Height = -11
        Font.Name = 'Tahoma'
        Font.Style = []
        ParentFont = False
        ScrollBars = ssVertical
        TabOrder = 0
        Zoom = 100
      end
    end
    object TabSheet3: TTabSheet
      Caption = #1048#1079#1086#1073#1088#1072#1078#1077#1085#1080#1103' '#1084#1086#1073#1086#1074
      ImageIndex = 2
      object MemoMobImages: TMemo
        Left = 0
        Top = 25
        Width = 741
        Height = 405
        Align = alClient
        ReadOnly = True
        TabOrder = 0
        ExplicitLeft = 96
        ExplicitTop = 96
        ExplicitWidth = 185
        ExplicitHeight = 89
      end
      object MobImagesPath: TPanel
        Left = 0
        Top = 0
        Width = 741
        Height = 25
        Align = alTop
        Alignment = taLeftJustify
        BevelOuter = bvNone
        Caption = 'MobImagesPath'
        TabOrder = 1
        ExplicitLeft = 144
        ExplicitTop = 16
        ExplicitWidth = 185
      end
    end
  end
end
